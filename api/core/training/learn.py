import numpy as np
import pandas as pd

import tensorflow as tf
from tensorflow import keras

from keras.models import Sequential

from keras.preprocessing.text import Tokenizer
from keras_preprocessing.sequence import pad_sequences

from sklearn.model_selection import train_test_split

import pickle

from db.hbase_db import scanHBase

# Develop

class TrainModel:

    def _load_data(self):
        self._data = scanHBase()

    def _data(self):
        # Preproccess
        data = self._data.drop(columns='trained')
        data = data.rename({'tweet': 'clean_text'}, axis=1)
        data = data.sample(frac = 1).reset_index(drop = True)
        return data


    def _split_data(self, tweets, labels):
        X_train, X_test, y_train, y_test = train_test_split(tweets, labels, test_size = 0.15)
        X_train, X_valid, y_train, y_valid = train_test_split(X_train, y_train, test_size = 0.2)

        return X_train, X_test, X_valid, y_train, y_test, y_valid


    def _feature_target(self, data):
        # Labels Data
        labels = pd.get_dummies(data.category)
        labels.columns = ["negative", "neutral", "positive"]

        # drop target
        data = data.drop(columns = "category")

        # tokenize
        tokenizer = Tokenizer(num_words = 8150, lower = True, split = " ", oov_token = "~")
        tokenizer.fit_on_texts(data["clean_text"])

        # Text to Token
        data["clean_text"] = tokenizer.texts_to_sequences(data["clean_text"])

        # Pad Sequence
        tweets = pad_sequences(data["clean_text"])

        return tweets, labels

    def initTrain(self):
        # Load Data
        data = self._data()

        # Feature and Target
        tweets, labels = self._feature_target(data)

        # Split Data
        X_train, X_test, X_valid, y_train, y_test, y_valid = self._split_data(tweets, labels)

        # Model
        model = Sequential([
            keras.layers.Embedding(input_dim=8150, output_dim=32),
            keras.layers.GRU(128),
            keras.layers.Dense(128, activation="leaky_relu",
                            kernel_initializer="he_normal", kernel_regularizer="l1"),
            keras.layers.Dropout(0.5),
            keras.layers.Dense(3, activation="softmax",
                            kernel_initializer="glorot_normal")
        ])
        # model.summary()
        model.fit(X_train, y_train)

        # Optimizer
        model.compile(optimizer = 'adam',loss = 'categorical_crossentropy',metrics = ['accuracy'])

        # Evaluate
        model.evaluate(X_test, y_test)

        # Save Model
        self._save_model(model)

    def study(self):
        # Load Data
        data = self._data()

        # Feature and Target
        tweets, labels = self._feature_target(data)

        # Load Model
        model = keras.models.load_model('core/model/twitter-seq')

        # Split Data
        X_train, X_test, X_valid, y_train, y_test, y_valid = self._split_data(tweets, labels)

        model.fit(X_train, y_train)

        model.compile(optimizer = 'adam',loss = 'categorical_crossentropy', metrics = ['accuracy'])

        # Save Model
        self._save_model(model)
        
    def _save_model(self, model):
        model.save('core/model/twitter-seq')

        filename = 'core/model/twitter-model.sav'
        pickle.dump(model, open(filename, 'wb'))

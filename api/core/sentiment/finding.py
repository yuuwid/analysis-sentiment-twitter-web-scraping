import pandas as pd
import pickle
import translators as ts

import core.sentiment.preprocess as spr

class Sentiment:
    
    def __init__(self):
        pass

    def fit_text(self, text: list, to_EN = False):
        text_input = []

        if (to_EN is True):
            for t in text:
                temp = ts.google(t, from_language="id", to_language="en",
                                if_ignore_limit_of_length=True)
                text_input.append(temp)
        else:
            text_input = text
        
        clean_text = pd.DataFrame(text_input, columns=['clean_text'])

        self._token_str = spr.tokenize(clean_text)

    def __load_model(self):
        filename = 'core/sentiment/model/twitter-model.sav'
        return pickle.load(open(filename, 'rb'))

    def predic(self):
        model = self.__load_model()
        token_str = self._token_str
        self._y_pred = model.predict(token_str)

    def conclusion(self):
        result = []
        for y_p in self._y_pred:
            index_max = max(range(len(y_p)), key=y_p.__getitem__)
            
            if (index_max == 0):
                result.append("Negative")
            elif (index_max == 1):
                result.append("Netral")
            elif (index_max == 2):
                result.append("Positive")

        return result
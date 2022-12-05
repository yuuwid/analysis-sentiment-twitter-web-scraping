from keras.preprocessing.text import Tokenizer
from keras_preprocessing.sequence import pad_sequences

def tokenize(clean_text):
    tokenizer = Tokenizer(num_words = 8150, lower = True, split = " ", oov_token = "~")
    tokenizer.fit_on_texts(clean_text["clean_text"])

    # word_index = tokenizer.word_index
    clean_text["clean_text"] = tokenizer.texts_to_sequences(clean_text["clean_text"])
    token_str = pad_sequences(clean_text["clean_text"]) #padding the sequences to get same shapes

    return token_str
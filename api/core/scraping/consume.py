import tweepy
from cleantext import clean
import csv
from core.scraping.secret import *


class Consume:

    def __init__(self, topic, max_topic = 10, return_type=dict, id_scrap=None):
        self.query = topic
        if max_topic > 100:
            paginate_max_topic = max_topic - 100
            max_topic = 100
        elif max_topic < 10:
            max_topic = 10
            paginate_max_topic = max_topic
        else:
            paginate_max_topic = max_topic

        self.max_topic = max_topic
        self.paginate_max_topic = paginate_max_topic
        self.id_scrap = id_scrap
        
        self.client = tweepy.Client(bearer_token=BEARER_TOKEN,
                       consumer_key=CONSUMER_KEY,
                       consumer_secret=CONSUMER_SECRET,
                       access_token=ACCESS_TOKEN,
                       access_token_secret=ACCESS_TOKEN_SECRET,
                       return_type=return_type
                       )
        

    def eats(self):
        tweets = tweepy.Paginator(self.client.search_recent_tweets,
                          query=self.query,
                          tweet_fields=['author_id', 'created_at', 'text'],
                          user_fields=['name', 'username'],
                          expansions=['entities.mentions.username'],
                          # place_fields=['country', 'country_code'],
                          max_results=self.max_topic
                          ).flatten(limit=self.paginate_max_topic)

        data = []

        for tweet in tweets:
            text = clean(tweet['text'],
                        fix_unicode=True,
                        to_ascii=True,
                        no_line_breaks=True,)
            temp = {
                'id_tweet': tweet['id'],
                'author_id': tweet['author_id'],
                'text': text,
                'created_at': tweet['created_at'],
            }
            if (self.id_scrap is not None):
                temp['id_scrap'] = self.id_scrap
                
            data.append(temp)
        
        self.results = data

    def to_csv(self, filename):

        field_names = ['id', 'author_id', 'text', 'created_at']

        with open(filename, 'w', encoding="utf-8") as csvfile:
            writer = csv.DictWriter(csvfile, fieldnames=field_names)
            writer.writeheader()
            writer.writerows(self.results)

from flask_restful import Resource, request

from core.scraping.consume import Consume
from core.sentiment.finding import Sentiment

from app.models.Tweet import Tweet


class RequestScrap(Resource):

    def post(self):
        json_data = request.get_json(force=True)

        try:
            tweet = json_data['tweet']
            n_tweet = json_data['n_tweet']
            id_request = json_data['id_request']
            # id_request = "1673177756"
            filter_sentiment = json_data['filter_sentiment']

            self.__scrap(tweet, n_tweet, id_request)
            self.__sentiment(id_request, filter_sentiment)

            return {'status': 'success', 'affected': len(Tweet.where("id_scrap", id_request))}
        except Exception:
            return {'status': 'failed', 'error': Exception}

    def __scrap(self, tweet, n_tweet, id_request):
        consume = Consume(topic=tweet, max_topic=n_tweet, id_scrap=id_request)
        consume.eats()
        results = consume.results
        self.__save_scrap(results)

        return results

    def __save_scrap(self, results):
        Tweet.insertAll(data=results)

    def __sentiment(self, id_scrap, filter_sentiment):
        data_dirty = Tweet.where('id_scrap', id_scrap)

        texts = []
        for d in data_dirty:
            texts.append(d['text'])

        senti = Sentiment()
        senti.fit_text(text=texts)
        senti.predic()
        results = senti.conclusion()

        updated_senti = []

        for i in range(len(results)):
            if (filter_sentiment['negative'] is True) and (results[i] == "Negative"):
                temp = {
                    'id': data_dirty[i]['id'],
                    'sentiment': results[i]
                }
                updated_senti.append(temp)
            elif (filter_sentiment['neutral'] is True) and (results[i] == "Netral"):
                temp = {
                    'id': data_dirty[i]['id'],
                    'sentiment': results[i]
                }
                updated_senti.append(temp)
            elif (filter_sentiment['positive'] is True) and (results[i] == "Positive"):
                temp = {
                    'id': data_dirty[i]['id'],
                    'sentiment': results[i]
                }
                updated_senti.append(temp)

        self.__update_sentiment(id_scrap, updated_senti)

    def __update_sentiment(self, id_scrap, updated_senti):
        Tweet.updateSentiment(updated_senti)


class RequestGetAllTweet(Resource):
    def post(self):
        json_data = request.get_json(force=True)

        id_scrap = json_data['id_request']
        # id_scrap = "1673177756"

        results = Tweet.where("id_scrap", id_scrap)

        responses = []
        for r in results:
            if r['sentiment'] is not None:
                responses.append(r)

        return responses


class RequestGetTweet(Resource):
    def post(self):
        json_data = request.get_json(force=True)

        id_tweet = json_data['id_tweet']

        return Tweet.where("id_tweet", id_tweet)

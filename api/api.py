from flask import Flask
from flask_restful import Api

from app.controllers.Controllers import *

app = Flask(__name__)
api = Api(app)

api.add_resource(RequestScrap, '/api/sentiment-scraping')

api.add_resource(RequestGetAllTweet, '/api/all')

api.add_resource(RequestGetTweet, '/api/get')

if __name__ == '__main__':
    app.run(debug=True)

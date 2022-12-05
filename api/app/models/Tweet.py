from db.cassandra_db import cdb
from app.config.db import KEYSPACE

class Tweet:

    @staticmethod
    def all():
        query = "SELECT * FROM {keyspace}.tweet;".format(keyspace=KEYSPACE)

        return cdb.query(query).fetch()

    @staticmethod
    def insertAll(data):
        query = """
            INSERT INTO {keyspace}.tweet (id, author_id, created_at, id_scrap, id_tweet, text) 
            VALUES (?, ?, ?, ?, ?, ?)
        """.format(keyspace=KEYSPACE)
        
        cdb.batchQuery(query, data)

    @staticmethod
    def where(key, value):
        query = "SELECT * FROM {keyspace}.tweet WHERE {key} = '{value}'".format(keyspace=KEYSPACE, key=key, value=value)

        return cdb.query(query).fetch()

    def updateSentiment(sentiment):
        for senti in sentiment:
            query = """
                UPDATE {keyspace}.tweet SET sentiment='{conclusion}' WHERE id='{id}'
            """.format(keyspace=KEYSPACE, conclusion=senti['sentiment'], id=senti['id'])

            cdb.query(query)

from app.config.db import PORT, BATCH_LIMIT

from cassandra.cluster import Cluster
from cassandra.cluster import BatchStatement, ConsistencyLevel
import bson
from collections import OrderedDict
import math

class CassandraDB:
    
    def __init__(self):
        clstr = Cluster(port=PORT)
        self.session = clstr.connect()


    def query(self, query):
        self._query_str = query
        return self.__execute()

    
    def batchQuery(self, query: str, data: list):
        batch_size = len(data)
        limit = BATCH_LIMIT
        temp_limit = 0
        new_limit = limit
        split_data = data[temp_limit:limit]

        insert_prepare = self.session.prepare(query)
        batch = BatchStatement(consistency_level=ConsistencyLevel.QUORUM)

        for i in range(math.ceil(batch_size / limit)):
            for temp in split_data:
                # print(temp['author_id'])
                temp = OrderedDict(sorted(temp.items()))
                li = list(temp.values())
                try:
                    id = str(bson.ObjectId())
                    li.insert(0, id)
                    insert = tuple(li)
                    batch.add(insert_prepare, insert)
                except Exception as e:
                    print(e)
                    pass

            temp_limit = new_limit
            new_limit = (i + 2) * limit

            if (new_limit > len(data)):
                split_data = data[temp_limit: ]
                new_limit = len(data)
            else:
                split_data = data[temp_limit: new_limit]

            self._query_str = batch
            self.__execute()
            batch.clear()

        return self

    def batchQueryDeprecated(self, query: str, data: list):
        insert_prepare = self.session.prepare(query)
        batch = BatchStatement(consistency_level=ConsistencyLevel.QUORUM)

        for temp in data:
            temp = OrderedDict(sorted(temp.items()))
            li = list(temp.values())
            try:
                id = str(bson.ObjectId())
                li.insert(0, id)
                insert = tuple(li)
                batch.add(insert_prepare, insert)
            except Exception as e:
                pass
        
        self._query_str = batch
        return self.__execute()


    def fetch(self):
        if (self.results.column_names is None):
            return self.results
        else:
            return self.__to_dict(self.results)
    

    def __execute(self):
        self.results = self.session.execute(self._query_str)

        return self


    def __to_dict(self, results):
        data = []
        for res in results:
            col_name = results.column_names
            res = list(res)
            res_dict = {col_name[i]: res[i] for i in range(len(col_name))}

            data.append(res_dict)
            
        return data


cdb = CassandraDB()
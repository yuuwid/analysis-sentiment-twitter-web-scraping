import happybase
import pandas as pd

def hbase():
    connection = happybase.Connection('localhost', port=9090)
    table = connection.table('tweet_sentiment')
    return table

def scanHBase():
    results = []
    filter = "SingleColumnValueFilter('trained', 'trained', =, 'substring:False')"
    for key, data in hbase().scan(filter=filter):
        # print(data)
        tweet = data[b'data:tweet'].decode('UTF-8')
        category = int(data[b'data:category'])
        trained = data[b'trained:trained'].decode('UTF-8')
        results.append([key, tweet, category, trained])
    return pd.DataFrame(results, columns=('key', 'tweet', 'category', 'trained'))

def updateTrained(key):
    table = hbase()
    table.put(key, {b'trained:trained': b'True'})

def batchUpdateTrained(keys):
    for key in keys:
        updateTrained(key)

def count():
    table = hbase()
    count = 0
    for _ in table.scan(filter='FirstKeyOnlyFilter() AND KeyOnlyFilter()'):
        count += 1

    return count

def puts(data):
    table = hbase()
    b = table.batch()

    i = count() + 1
    for d in data.values:
        tweet = d[0]
        category = str(int(d[1]))
        
        b.put(str(i), {b'data:tweet': tweet, b'data:category': category, b'trained:trained': b'False'})

        i += 1

    b.send()

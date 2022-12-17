<?php ?>

<?php need('partials/main-header') ?>

<body class="main-background">

    <div class="container my-5">
        <div class="text-center">
            <div class="d-flex justify-content-center">
                <section class="row mb-3">
                    <div class="col col-2">
                        <img src="./images/senti/twt.png" width="50" alt="">
                    </div>
                    <div class="col col-10 text-center">
                        <h5><b>SENTIMENT ANALYSIS</b></h5>
                        <h5 class="text-primary"><b>TWITTER</b></h5>
                    </div>
                </section>
            </div>
        </div>

        <div class="card p-4">
            <div class="row">
                <div class="col align-self-center">
                    <div class="d-flex justify-content-center">
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <img src="./images/senti/negative.png" width="70">
                                    <p class="mb-1">Negative</p>
                                    <p><?= $data['counts'][0] ?></p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center">
                                    <img src="./images/senti/neutral.png" width="70">
                                    <p class="mb-1">Neutral</p>
                                    <p><?= $data['counts'][1] ?></p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center">
                                    <img src="./images/senti/positive.png" width="70">
                                    <p class="mb-1">Positive</p>
                                    <p><?= $data['counts'][2] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <section>
                        <h5 class="mb-1">ID Sentiment</h5>
                        <p class="mb-2"><?= $data['sentiment']['id_sentiment'] ?></p>
                    </section>
                    <section>
                        <h5 class="mb-1">Tweet</h5>
                        <p class="mb-2 line-ellipsis-2"><?= $data['sentiment']['tweet'] ?></p>
                    </section>
                    <section>
                        <h5 class="mb-1">Banyak Tweet</h5>
                        <p class="mb-2"><?= $data['sentiment']['n_tweet'] ?></p>
                    </section>
                    <section>
                        <h5 class="mb-1">Waktu</h5>
                        <p class="mb-2"><?= $data['sentiment']['time'] ?></p>
                    </section>
                </div>
            </div>
            <hr>

            <div class="row row-cols-2 gx-5 gy-3">
                <?php foreach ($data['histories'] as $history) : ?>
                    <a href="detail?id_history=<?= $history['_id'] ?>" class="link-result" target=”_blank”>
                        <div class="col">
                            <div class="card p-3 border border-dark">
                                <section class="row">
                                    <div class="col">
                                        <p class="mb-0"><b>Tweet</b></p>
                                        <p class="line-ellipsis-3"><?= $history['text'] ?></p>
                                    </div>
                                    <div class="col col-3 align-self-center">
                                        <div class="text-center">
                                            <?php if ($history['sentiment'] == 'Positive') : ?>
                                                <img src="./images/senti/positive.png" width="50">
                                                <p>Positive</p>
                                            <?php elseif ($history['sentiment'] == 'Netral') : ?>
                                                <img src="./images/senti/neutral.png" width="50">
                                                <p>Neutral</p>
                                            <?php elseif ($history['sentiment'] == 'Negative') : ?>
                                                <img src="./images/senti/negative.png" width="50">
                                                <p>Negative</p>

                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>

            </div>

        </div>
    </div>

</body>

<?php need('partials/main-footer') ?>
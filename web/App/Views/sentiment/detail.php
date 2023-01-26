<?php  ?>

<?php need('partials/main-header') ?>

<body class="main-background">

    <div class="container mt-5">
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

        <div class="card p-4 mx-5">
            <div class="row">
                <div class="col">
                    <section>
                        <h5 class="mb-2">ID Sentiment</h5>
                        <p class="mb-3"><?= $data['id_scrap'] ?></p>
                    </section>
                    <section>
                        <h5 class="mb-2">ID Tweet</h5>
                        <p class="mb-3"><?= $data['id_tweet'] ?></p>
                    </section>
                    <section>
                        <h5 class="mb-2">User ID</h5>
                        <p class="mb-3"><?= $data['author_id'] ?></p>
                    </section>
                    <hr>
                    <section>
                        <h5 class="mb-2">Tweet</h5>
                        <p class="mb-3">
                            <?= $data['text'] ?>
                        </p>
                    </section>
                    <hr>
                    <section>
                        <h5 class="mb-2">Created At</h5>
                        <?php
                        $date = date_create($data['created_at']);
                        ?>
                        <p class="mb-2"><?= date_format($date, "l, d F Y"); ?></p>
                    </section>
                </div>
                <div class="col">
                    <div class="text-center">
                        <h3>Result Sentiment</h3>
                        <div class="text-center mt-5">
                            <?php if ($data['sentiment'] == 'Positive') : ?>
                                <img src="./images/senti/positive.png" width="100">
                                <p>Positive</p>
                            <?php elseif ($data['sentiment'] == 'Netral') : ?>
                                <img src="./images/senti/neutral.png" width="100">
                                <p>Neutral</p>
                            <?php elseif ($data['sentiment'] == 'Negative') : ?>
                                <img src="./images/senti/negative.png" width="100">
                                <p>Negative</p>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<?php need('partials/main-footer') ?>
<?php

use Lawana\Message\Flasher;

  ?>

<?php need('partials/main-header') ?>

<body class="main-background">

    <div class="position-absolute top-50 start-50 translate-middle w-50">
        <div class="container">
            <div>
                <?= Flasher::show('error') ?>
            </div>
            <div class="card p-3 text-center">
                <section class="m-2">
                    <img src="./images/senti/twt.png" width="120" alt="">
                </section>
                <section>
                    <h3><b>SENTIMENT ANALYSIS</b></h3>
                    <h3 class="text-primary"><b>TWITTER</b></h3>
                </section>
                <br class="mt-4">
                <form action="./req-api" method="post">
                    <section class="">
                        <div class="mb-3 mx-5">
                            <label class="form-label fs-5"><b>Kata Kunci Tweet</b></label>
                            <input type="text" name="tweet" class="form-control text-center border border-primary" placeholder="<?= $data['rekom'] ?>" required>
                        </div>
                        <section class="d-flex justify-content-center">
                            <div class="mb-3 mx-5 w-25">
                                <label class="form-label fs-5"><b>Kata Kunci Tweet</b></label>
                                <input type="number" name="n_tweet" value="10" min="10" max="100" class="form-control text-center border border-primary">
                            </div>
                        </section>
                    </section>
                    <br class="mt-4">
                    <section>
                        <div class="d-grid gap-2 col-6 mx-auto w-25">
                            <button class="btn btn-primary" type="submit">Check</button>
                        </div>
                    </section>
                </form>

                <br class="mt-5">
                <br class="mt-5">

                <div class="d-flex justify-content-center">
                    <div class="row ">
                        <div class="col">
                            <div class="text-center">
                                <img src="./images/senti/negative.png" width="50">
                                <p>Negative</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <img src="./images/senti/neutral.png" width="50">
                                <p>Neutral</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <img src="./images/senti/positive.png" width="50">
                                <p>Positive</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>

</body>

<?php need('partials/main-footer') ?>
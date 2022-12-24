<?php ?>

<?php need('partials/main-header') ?>

<body class="main-background">

    <div class="container my-5">
        <div class="text-center">
            <div class="d-flex justify-content-center">
                <section class="row mb-3">
                    <div class="col col-2">
                        <a class="text-decoration-none" href="./">
                            <img src="./images/senti/twt.png" width="50" alt="">
                        </a>
                    </div>
                    <div class="col col-10 text-center">
                        <h5><b>SENTIMENT ANALYSIS</b></h5>
                        <h5 class="text-primary"><b>TWITTER</b></h5>
                    </div>
                </section>
            </div>
        </div>

        <div class="card p-5 text-center">
            <div class="text-center mb-3">
                <img src="./images/senti/notfound.png" width="100">
            </div>
            <h4>ID Sentiment : <?= $data['id_sentiment'] ?></h4>
            <h3>Not Found</h3>

        </div>
    </div>

</body>

<?php need('partials/main-footer') ?>
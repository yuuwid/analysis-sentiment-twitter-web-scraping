<?php

use Lawana\Message\Flasher;

?>

<?php need('partials/main-header') ?>

<body class="main-background">

    <div class="position-absolute top-50 start-50 translate-middle w-50">
        <div class="container">
            <div>
                <?= Flasher::show('error') ?>
                <?= Flasher::show('clear-history-status') ?>
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
                            <label class="form-label fs-5"><b>Keyword Tweet</b></label>
                            <input type="text" name="tweet" class="form-control text-center border border-primary" placeholder="<?= $data['rekom'] ?>" required>
                        </div>
                        <section class="d-flex justify-content-center">
                            <div class="mb-3 mx-5 w-25">
                                <label class="form-label fs-5"><b>How Much ?</b></label>
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

                    <br class="mt-5">
                    <br class="mt-5">

                    <div class="d-flex justify-content-center">
                        <div class="row ">
                            <div class="col">
                                <div class="text-center">
                                    <label for="negative-check">
                                        <img src="./images/senti/negative.png" width="50">
                                    </label>
                                    <p>Negative</p>
                                    <input class="form-check-input mt-0" type="checkbox" value="0" checked id="negative-check" name="negative-check">
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center">
                                    <label for="neutral-check" class="p-0">
                                        <img src="./images/senti/neutral.png" width="50">
                                    </label>
                                    <p>Neutral</p>
                                    <input class="form-check-input mt-0" type="checkbox" value="1" checked id="neutral-check" name="neutral-check">
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-center">
                                    <label for="positive-check">
                                        <img src="./images/senti/positive.png" width="50">
                                    </label>
                                    <p>Positive</p>
                                    <input class="form-check-input mt-0" type="checkbox" value="2" checked id="positive-check" name="positive-check">
                                </div>
                            </div>
                        </div>
                </form>


            </div>
        </div>


    </div>
    </div>

    <div>
        <div class="dropup position-absolute bottom-0 end-0 rounded-circle m-5">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#historyModal">
                <i class="bi bi-clock-history"></i>
            </button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Search History Sentiment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="results" method="get">
                        <div class="mb-3 mx-5">
                            <label for="id_sentiment" class="form-label"><b>ID Sentiment</b></label>
                            <input type="text" class="form-control" id="id_sentiment" name="id_sentiment">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyModal">History Sentiment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="text-center mb-5">The history below will automatically disappear in the next 10 Minutes.</h5>
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Id Sentiment</th>
                                <th scope="col">Tweet</th>
                                <th scope="col">Time</th>
                                <th scope="col">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['history'] as $h) : ?>
                                <tr class="text-center">
                                    <th scope="row"><?= $h['id_sentiment'] ?></th>
                                    <td><?= $h['tweet'] ?></td>
                                    <td><?= $h['time'] ?></td>
                                    <td>
                                        <a href="results?id_sentiment=<?= $h['id_sentiment'] ?>" target="blank" class="btn btn-sm btn-primary">
                                            <i class="bi bi-file-earmark-ruled"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mb-4">
                    <form action="clear-history" method="post">
                        <button class="btn btn-danger" type="submit">Clear History</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<?php need('partials/main-footer') ?>
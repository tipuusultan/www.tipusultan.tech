<main>
    <div class="container py-lg-md d-flex">
        <div class="col px-0">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="display-3 "><?php language('_DOWNLOADIGTV'); ?></h1>
                    <div class="form-group">
                        <label><?php language('_PLACEHOLDER11'); ?></label>
                        <input type="url" id="input" name="input" class="form-control" placeholder="<?php language('_PLACEHOLDER11'); ?>">
                        <input type="hidden" name="action" id="action" value="igtvVideos">
                        <input type="hidden" name="json" id="json" value="">
                        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>">
                        <button id="btnDownloadIgtvVideos" class="btn btn-default btn-block mt-3">
                            <i class="fas fa-download"></i> <?php language('_DOWNLOAD'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="downloadArea" class="section section-sm bg-gradient-white">
        <div class="container pt-sm-0 ">
            <div class="row text-center justify-content-center">
                <div class="col-lg-10" id="infoBox"></div>
            </div>
            <div class="row row-grid mt-5">
                <div class="col-lg-2" id="posterInfo"></div>
                <div class="col-lg-10">
                    <div class="row" id="downloadLinks"></div>
                </div>
            </div>
        </div>
    </section>
    <?php include_once __DIR__ . '/features.php'; ?>
</main>
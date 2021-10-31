<main>
    <div class="container py-lg-md d-flex">
        <div class="col px-0">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="display-3 "><?php language('_DOWNLOADPRIVATEPOST'); ?></h1>
                    <div class="form-group">
                        <label><?php language('_PLACEHOLDER4'); ?></label>
                        <input type="url" id="input" name="input" class="form-control" placeholder="<?php language('_PLACEHOLDER4'); ?>">
                        <label><?php language('_PLACEHOLDER7'); ?></label>
                        <div class="input-group">
                            <input type="text" id="input-source-link" name="input-source-link" class="form-control" placeholder="<?php language('_PLACEHOLDER7'); ?>" readonly>
                            <button type="button" class="btn btn-secondary btn-paste" id="copy"><?php language('_PLACEHOLDER9'); ?></button>
                        </div>

                        <label><?php language('_PLACEHOLDER8'); ?></label>
                        <div class="input-group">
                        <textarea id="input-page-source" name="input-page-source" class="form-control"></textarea>
                            <button type="button" class="btn btn-secondary btn-paste" id="paste"><?php language('_PLACEHOLDER10'); ?></button>
                        </div>
                        <input type="hidden" name="action" id="action" value="privatePost">
                        <input type="hidden" name="json" id="json" value="">
                        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>">
                        <button id="btnDownloadPrivatePost" class="btn btn-default btn-block mt-3">
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
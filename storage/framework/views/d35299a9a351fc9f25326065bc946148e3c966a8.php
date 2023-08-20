


<?php $__env->startSection('css-styles'); ?>
 
    <link href="<?php echo e(asset('css/ksu_css/tabs.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/ksu_css/modal_window.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('main'); ?>

    <!-- JS for categories -->
    <?php echo $__env->make('admin.admin-settings-js-categories', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <!-- JS for Alias Names/Accounts -->
    <?php echo $__env->make('admin.admin-settings-js-alias-names', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    


    <h1>Settings</h1>
    

    <div class="tabset">
        <!-- Tab 1 -->
        <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
        <label for="tab1">Categories</label>

        <!-- Tab 2 -->
        <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
        <label for="tab2">Alias Names</label>

        <!-- Tab 3 -->
        <input type="radio" name="tabset" id="tab3" aria-controls="dunkles">
        <label for="tab3">Server Settings</label>
    
        <div class="tab-panels">
            <section id="categories" class="tab-panel">
                <?php echo $__env->make('admin.admin-settings-categories', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </section>

            <section id="alias_names" class="tab-panel">
                <?php echo $__env->make('admin.admin-settings-alias-names', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </section>

            <section id="server_settings" class="tab-panel">
                <h2>Server Settings</h2>
                <p><strong>Vestibulum laoreet:</strong> Vivamus rhoncus sit amet dui ut iaculis. Mauris interdum convallis metus pretium ullamcorper. Mauris tristique pharetra ligula, eu fermentum tortor iaculis eget. Donec rhoncus arcu ac sem efficitur, at viverra velit tincidunt. Ut sed ipsum facilisis lorem iaculis porttitor. Suspendisse a mattis erat, a imperdiet orci. Pellentesque quis lorem non turpis maximus lobortis nec eu felis. In consequat non metus eu dictum.</p>
                <p><strong>Nulla ultricies:</strong> Curabitur finibus sit amet felis eget egestas. Donec tincidunt vulputate interdum. Vestibulum mi sapien, tempor eget aliquet eu, aliquam id eros. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vestibulum aliquam eros sed eros feugiat, in vehicula justo varius. Mauris egestas dolor ex, id viverra turpis finibus id. Cras porta leo sed erat iaculis, in interdum magna ornare. Duis quis luctus sem. Sed a auctor massa, ut elementum tellus. Sed semper diam convallis augue vulputate, vel tincidunt augue dignissim. Nam ipsum tellus, tempor cursus pharetra eget, semper quis enim. Etiam tincidunt sapien nisi, eget porttitor nunc semper sit amet. Sed ornare lobortis tellus et vehicula.</p>
            </section>
        </div>
    
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/admin/admin-settings.blade.php ENDPATH**/ ?>
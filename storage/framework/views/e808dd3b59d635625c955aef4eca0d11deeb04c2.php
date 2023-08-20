<!-- ====================================================================================================== 


 * Admin settings post view   
 
 * URL - APP_URL/settings

 * CHILD VIEW of - admin.admin-master    

 * What page is doing: 
    - Categories
        > edit/add categories
    - Alias Names
        > edit/add alias names
        > assign/remove alias names for users to use
    - Toast Settings
        >  set messages/positions for toast alerts
    - 
 
 * Controller 
    - PageController@settingsPage() -> AdminController@adminSettings()
        > route - /settings


    CATEGORIES TAB
    ===============

    - AjaxController@getCategoriesEdit() populate categories tab with categories to edit
        > route - /get-categories-edit

    - AjaxController@getCategory() get category to edit in modal
        > route - /get-category/{id}


    - AjaxController@editCategory() update the category after editing
        > route - /edit-category/{id}/{value}


    - AjaxController@addCategory() add new category
        > route - /add-category


    ALIAS NAMES TAB
    ===============

    - AjaxController@getAccountsEdit() populate alias names tab wit alias names to edit
        > route - /get-accounts-edit


    - AjaxController@getAccount() get alias name chosen to edit in modal window
        > route -/get-account/{id}


    - AjaxController@editAccount() update the account name in accounts table after user edits
        > route - /edit-account/{id}/{value}
        

    - AjaxController@addAccount() add new alias name
        > route - /add-account
    

    - AjaxController@searchUsersPairAccount() search users to pair alias name to
        > route - /search-users-pair-account


    - AjaxController@getAccounts() get all accounts to be able to pair with users
        > route - /get-accounts


    - AjaxController@attachUserAccountPair() associate the alias name with user
        > route - /attach-user-account-pair


    - AjaxController@detachUserAccountPair() remove alias name & user association
        > route - /detach-user-account-pair



    TOAST TAB
    ===============
        
    - AjaxController@getAllToastData() get all toasts 
        > route - /get-all-toast-data


    - AjaxController@updateToast() update toast
        > route - /update-toast


    - AjaxController@addNewToastMessage() add new message to messages table
        > route - /add-new-toast-message





 * JS file 
    - app/public/js/root.js
    - app/public/js/admin/admin-settings-categories.js
    - app/public/js/admin/admin-settings-pair-user-alias.js
    - app/public/js/admin/admin-settings-toast.js
    - app/public/js/admin/admin-settings-alias-names.js
    - app/public/js/toast/global-toast-variables-functions.js
    

 * CSS file
    - 
====================================================================================================== -->





<!-- yield from admin-master.blade.php -->
<?php $__env->startSection('admin-js-scripts'); ?>
    <script src="<?php echo e(asset('js/admin/settings/alias-names-tab/alias-names.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/settings/alias-names-tab/pair-user-alias.js')); ?>"></script>

    <script src="<?php echo e(asset('js/admin/settings/toast-settings-tab/toast.js')); ?>"></script>

    <script src="<?php echo e(asset('js/admin/settings/general-system-config-tab/digest-email.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/settings/general-system-config-tab/num-posts-displayed.js')); ?>"></script>

    <!-- Used by admin-settings-pair-user-alias.blade.php -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<?php $__env->stopSection(); ?>


<!-- yield from admin-master.blade.php -->
<?php $__env->startSection('admin-css-styles'); ?>
    <link href="<?php echo e(asset('css/ksu_css/tabs.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/ksu_css/modal_window.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/ksu_css/admin_settings.css')); ?>" rel="stylesheet">

    <!-- Used by admin-settings-pair-user-alias.blade.php -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<?php $__env->stopSection(); ?>


<!-- yield from component.app-base -->
<?php $__env->startSection('main'); ?>
    <!-- switching between tab inputs wont work properly unless this js file is here.  -->
    <script src="<?php echo e(asset('js/admin/settings/categories-tab/categories.js')); ?>"></script>

    <h1>Settings</h1>
    

    <div class="tabset">
        <!-- Categories Tab -->
        <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
        <label for="tab1">Categories</label>

        <!-- Alias Names Tab -->
        <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
        <label for="tab2">Alias Names</label>

        <!-- Toast Settings Tab -->
        <input type="radio" name="tabset" id="tab3" aria-controls="dunkles">
        <label for="tab3">Toast Settings</label>
    
        <!-- Toast Settings Tab -->
        <input type="radio" name="tabset" id="tab4" aria-controls="">
        <label for="tab4">General System Configurations</label>


        <div class="tab-panels">
            <section id="categories" class="tab-panel">   
                <?php echo $__env->make('admin.settings.categories-tab.categories', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </section>

            <section id="alias_names" class="tab-panel">
                <?php echo $__env->make('admin.settings.alias-names-tab.alias-names', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <hr>
                <?php echo $__env->make('admin.settings.alias-names-tab.pair-user-alias', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </section>

            <section id="toast_settings" class="tab-panel">
                <?php echo $__env->make('admin.settings.toast-settings-tab.toast-settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </section>

            <section id="general_settings" class="tab-panel">
                <!-- include digest-email blade -->
                <?php echo $__env->make('admin.settings.general-system-config-tab.digest-email', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('admin.settings.general-system-config-tab.num-posts-displayed', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </section>
        </div>
    
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ksutodaytest/resources/views/admin/settings/admin-settings.blade.php ENDPATH**/ ?>

<!-- ====================================================================================================== -->
<!-- Contributors index view                                                                                -->
<!-- CHILD VIEW of: contributor-master.blade.php                                                            -->

<!-- #header @navbar  includes:                                                                              -->
<!--    1) Home btn(user-index.blade.php)                                                                   -->
<!--    2) Read Posts btn(inc/read-all-posts.blade.php)                                                     -->
<!--    3) Create Posts btn(inc/create-post.blade.php)                                                      -->

<!-- #main includes: Filler text for now                                                                    -->

<!-- #sidebar-right includes:                                      -->
<!--    1) My Posts btn(inc/read-my-posts.blade.php) -->
<!--    2) Posts Status btn(inc/view-posts-status.blade.php) -->

<!-- ====================================================================================================== -->




<?php $__env->startSection('main'); ?>
    <p>
        KSU Today is Kennesaw State University's system for posting and viewing campus announcements for faculty and staff every Monday through 
        Friday except on holidays. Using KSU Today, faculty and staff can submit an announcement to be included on the site.&nbsp; All submitted 
        posts are moderated prior to being published.
    </p>

    <p>User Information:</p>

    <p>&nbsp;</p>

    <ul>
        <li style="margin: 0in 0in 0.0001pt; text-align: start; -webkit-text-stroke-width: 0px;"><a href="https://stratcomm.kennesaw.edu/docs/ksu_today_guidelines.pdf" target="_blank" title="KSU Today Content Guidelines">KSU Today content guidelines</a></li>
        <li style="margin: 0in 0in 0.0001pt; text-align: start; -webkit-text-stroke-width: 0px;"><a href="https://apps.kennesaw.edu/files/pr_app_uni_cdoc/doc/KSU_Today_Read_Search_Posts.pdf" target="_blank" title="Viewing and Searching Posts">Viewing and Searching Posts</a></li>
        <li style="margin: 0in 0in 0.0001pt; text-align: start; -webkit-text-stroke-width: 0px;"><a href="https://apps.kennesaw.edu/files/pr_app_uni_cdoc/doc/KSU_Today_Create_Posts.pdf" target="_blank" title="Creating Posts">Creating Posts</a></li>
        <li style="margin: 0in 0in 0.0001pt; text-align: start; -webkit-text-stroke-width: 0px;"><a href="https://apps.kennesaw.edu/files/pr_app_uni_cdoc/doc/KSU_Today_Log_In_Opt-In.pdf" target="_blank" title="Subscribing to the KSU Today Email Digest">Subscribing to the KSU Today digest</a></li>
    </ul>

    <p>&nbsp;</p>

    <p>
        For questions or assistance with KSU Today, please contact the KSU Service Desk (<u><a href="mailto:service@kennesaw.edu">service@kennesaw.edu</a></u>) 
        or the Office of Strategic Communications and Marketing (<u><a href="mailto:stratcomm@kennesaw.edu">stratcomm@kennesaw.edu</a></u>).
    </p>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('contributor.contributor-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KSUT_route_middleware_auth_repo\resources\views/contributor/contributor-index.blade.php ENDPATH**/ ?>
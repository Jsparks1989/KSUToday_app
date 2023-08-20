
<!-- ====================================================================================================== -->
<!-- Home | Users index view -->
<!-- CHILD VIEW of: user-master.blade.php                                                                   -->

<!-- #header @navbar includes: 1) Home btn(user-index.blade.php), 2) Read Posts btn(inc/read-all-posts.blade.php)-->
<!-- #main includes: Filler text for now -->
<!-- #sidebar-right includes: Nothing (logout btn is in user-master)                                        -->

<!-- ====================================================================================================== -->




@extends('user.user-master')



@section('main')




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


@endsection
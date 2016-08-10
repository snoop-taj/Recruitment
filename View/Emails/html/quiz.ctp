<p> Dear <?= $data['Application']['first_name']; ?>,</p> <br />
<p>Your application for the position of <?= $data['Job']['title']; ?> has been reviewed. To progress
with your application we'd like you complete an online test as part of our hiring  process. 
It's meant to assess your skills in <?= $data['Job']['title']; ?> position and give us an idea of your skills. 
You will have <?=$data['Quiz']['duration']; ?> min to
complete the test once started. Please click on the following link to see details before you start.</p> <br />
<p>
<?php echo "<a herf='https://www.travelfusion.com/corporate/quiz/detail/{$data['Quiz']['id']}/{$data['Application']['id']}'>
https://www.travelfusion.com/corporate/quiz/detail/{$data['Quiz']['id']}/{$data['Application']['id']}
</a>";
?>
</p> <br />

<p> Please send us your answers by <?= $data['Quiz']['end_date']; ?>. A member of HR team will be in touch once your test is complete. </p> <br />

<p>We will be glad to answer any questions, so feel free to contact us anytime</p> <br />

<p>Kind Regards,</p> <br />



<p>Recruitment Team</p> <br />
<p>TravelFusion</p>
<p>London team: </p> <br />
<p><a href='www.travelfusion.com/corporate' target="_blank">www.travelfusion.com/corporate</a></p>
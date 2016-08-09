function hide_option(val) {
        if (val == 'short' || val == 'long') {
                $("#QuestionNoOfOptions, label[for=QuestionNoOfOptions").hide();
        } else {
            $("#QuestionNoOfOptions, label[for=QuestionNoOfOptions").show();
        }
}

function add_question(questionId, quizId) {
        var formData = {quid:quizId};
        $.ajax({
                type: "GET",
                url:quizId+"/"+questionId,
                dataType:"json",
                success: function(data) {
                        $('#q'+questionId).html(data);
                }, 
                error: function(xhr, status, strErr){
                        
                }
        });
}

function show_question_stat(id) {
        if ($('#stat-'+id).css('display') == 'none') {
                $('#stat-'+id).show();
        } else {
                $('#stat-'+id).hide();
        }
}
function add_score(resultId, questionNo, score) {
        if (confirm('Are you sure you want evelauate this answer?')) {
                var data = {
                        resultId: resultId,
                        questionNo: questionNo,
                        score: score
                };
                
                $.ajax({
                        type: "GET",
                        url: "/admin/recruitment/quizzes/evaluate_score",
                        data : data,
                        success: function(data) {
                                if (data) {
                                        window.location = '/admin/recruitment/results/view/' + resultId;
                                }
                        }
                });
        }
}

var timer = {
        countTime: 0,
        individualTime: new Array(),
        create_time: function(timerId, time) {
                this.timerId = timerId;
                this.totalSeconds = time;

                timer.update_timer();
                window.setTimeout(timer.tick, 1000);
        },
        update_timer: function() {
                var seconds = timer.totalSeconds;
                
                var days = Math.floor(seconds/ 86400);
                seconds -= days * 86400;
                
                var hours = Math.floor(seconds/ 3600);
                seconds -= hours * 3600;
                
                var minutes = Math.floor(seconds/ 60);
                seconds -= minutes * 60;
                
                var timeString = ((days > 0) ? day + ' days ' : '') + this.leading_zeros(hours) + ':' + this.leading_zeros(minutes) + ':' + this.leading_zeros(seconds);
                $('#'+timer.timerId).html(timeString); 
                
                
        },
        tick: function() {
                if (timer.totalSeconds <= 0)  {
                    alert("Time's up!");
                    return;
                }
                
                timer.totalSeconds -= 1;
                timer.update_timer();
                window.setTimeout(timer.tick, 1000);
        },
        leading_zeros: function(time) {
            return (time < 10) ? '0' + time : + time;
        },
        increase_time: function() {
                timer.countTime += 1;
        }
}

var quiz = {
        submitUrl: '',
        noOfQuestion: 0,
        questionNo: 0,
        lastQuestion: 0, 
        answered: 'btn-success',
        unanswered: 'btn-danger',
        review: 'btn-warning',
        reviewed: new Array(),
        show_question: function(e) {
                this.change_color(e);
                this.hide_all_question();
                
                var qId = '#q-'+e;
                $(qId).show();
                
                if (e >= 1) $('#back-btn').css('visibility', 'visible');
                if (e < this.noOfQuestion) $('#next-btn').css('visibility', 'visible');
                if (e == 0) $('#back-btn').css('visibility', 'hidden');
                if ((parseInt(e)+1) == this.noOfQuestion) $('#next-btn').css('visibility', 'hidden');
                
                this.questionNo = e;
                this.lastQuestion = e;
                
                this.set_individual_time(this.lastQuestion);
                this.save_answer(this.lastQuestion);
        },
        hide_all_question: function() {
                for(var i = 0; i <= this.noOfQuestion; i++) {
                        $('#q-'+i).hide();
                }
        },
        change_color: function(e) {
                var btnId = '#question-btn-'+e;
                var qType = '#q-type-'+e;
                
                var btnColor = $(btnId).attr('class').slice(4);
                
                if (btnColor != this.answered && btnColor != this.review) {
                        $(btnId).removeClass(btnColor).addClass(this.unanswered);
                }
                
                if (this.lastQuestion >= '0' && btnColor != this.review) {
                        var lbtnId = '#question-btn-'+this.lastQuestion;
                        var lbtnColor = $(lbtnId).attr('class').slice(4);
                        
                        switch($(qType).val()) {
                                case 'single':
                                case 'multiple':


                                    
                                        for (var i = 0; i <= 10; i++) {
                                                if ($('#ans-val-'+this.lastQuestion+'-'+i).length) {
                                                    if ($('#ans-val-'+this.lastQuestion+'-'+i).attr('checked') !== undefined) {
                                                            $(lbtnId).removeClass(lbtnColor).addClass(this.answered);
                                                            break;
                                                    } else {
                                                            $(lbtnId).removeClass(lbtnColor).addClass(this.unanswered);
                                                    }
                                     
                                        }
                                    }
                                    break;
                                    
                                case 'short':
                                case 'long':
                                    if ($('#ans-val-'+this.lastQuestion).length) {
                                            if ($('#ans-val-'+this.lastQuestion).val() !== '') {
                                                    $(lbtnId).removeClass(lbtnColor).addClass(this.answered);
                                            } else {
                                                    $(lbtnId).removeClass(lbtnColor).addClass(this.unanswered);
                                            }
                                    }
                                    break;
                        }
                }
        },
        set_individual_time: function(tCount) {
                if (tCount === undefined || tCount == null) {
                        var tCount = '0';
                }

                if (tCount == '0') { 
                        timer.individualTime[quiz.questionNo] = parseInt(timer.individualTime[quiz.questionNo]) + parseInt(timer.countTime);
                } else {
                        timer.individualTime[tCount] = parseInt(timer.individualTime[tCount]) + parseInt(timer.countTime);
                }
                
                timer.countTime = 0;
                $('#individual_time').val(timer.individualTime.toString());
                
                var data = {individual_time: $('#individual_time').val()};
                
                $.ajax({
                        data: data,
                        url: '/quiz/set_individual_time/'
                });
        },
        save_answer: function() {
                $('#signal-2').addClass('signal-green');
                window.setTimeout(function(){
                        $('#signal-2').removeClass('signal-green');
                }, 5000);
                
                var data = $('form').serialize();
                
                $.ajax({
                        type: 'GET',
                        data: data,
                        url: '/quiz/save_answer',
                        success: function() {
                                $('#signal-1').addClass('signal-green');
                                window.setTimeout(function(){
                                        $('#signal-1').removeClass('signal-green');
                                }, 5000);
                        }, 
                        error: function() {
                                $('#signal-1').addClass('signal-red');
                                window.setTimeout(function(){
                                        $('#signal-1').removeClass('signal-red');
                                }, 5500);
                        }
                });
        },
        next_question: function() {
                
                if ((parseInt(this.questionNo) + 1) < this.noOfQuestion) {
                        this.hide_all_question();
                        this.questionNo = (parseInt(this.questionNo) + 1);
                        $('#q-'+this.questionNo).show();
                }
                
                if ((parseInt(this.questionNo) + 1) == this.noOfQuestion) {
                        $('#next-btn').css('visibility', 'hidden');
                }
                
                if (this.questionNo >= 1) {
                        $('#back-btn').css('visibility', 'visible');
                }
                
                this.change_color(this.lastQuestion);
                this.set_individual_time(this.lastQuestion);
                this.save_answer();
                
                this.lastQuestion = this.questionNo;
        },
        prev_question: function() {
                
                if((parseInt(this.questionNo) - 1) >= 0) {
                        this.hide_all_question();
                        this.questionNo = (parseInt(this.questionNo) - 1);
                        $('#q-'+this.questionNo).show();
                }
                
                if (this.questionNo == 0) {
                        $('#back-btn').css('visibility', 'hidden');
                }
                
                if (this.questionNo < this.noOfQuestion) {
                        $('#next-btn').css('visibility', 'visible');
                }
                
                this.change_color(this.lastQuestion);
                this.set_individual_time(this.lastQuestion);
                this.save_answer();
                
                this.lastQuestion = this.questionNo;
        },
        clear: function() {
                var qType = '#q-type-' + this.questionNo;
                var btnId = '#question-btn-' + this.questionNo;
                var btnColor = $(btnId).attr('class').slice(4);
                
                switch($(qType).val()) {
                        case 'single':
                        case 'multiple':
                            for (var i = 0; i <= 10; i++) {
                                    if ($('#ans-val-'+this.questionNo+'-'+i).attr('checked') !== undefined) {
                                            $('#ans-val-'+this.questionNo+'-'+i).removeAttr('checked');
                                    }
                            }
                            break;

                        case 'short':
                        case 'long':
                            if ($('#ans-val-'+this.questionNo).attr('checked') !== undefined) {
                                   $('#ans-val-'+this.questionNo).val('');
                            }
                            break;
                }
                
                $(btnId).removeClass(btnColor).addClass(this.unanswered);
        },
        review_later: function() {

                var btnId = '#question-btn-' + this.questionNo;
                var btnColor = $(btnId).attr('class').slice(4);

                if (this.reviewed[this.questionNo] != undefined && this.reviewed[this.questionNo]) {
                        this.reviewed[this.questionNo] = false;
                        $(btnId).removeClass(btnColor).addClass(this.unanswered);
                } else {
                        this.reviewed[this.questionNo] = true;
                        $(btnId).removeClass(btnColor).addClass(this.review);
                }
        },
        cancel_move: function() {
                this.save_answer();
                
                if ($('#warning').css('display') == 'none') {
                        $('#warning').removeClass('hide');
                } else {
                        $('#warning').addClass('hide');
                }
        },
        submit_quiz: function() {
                this.set_individual_time(this.lastQuestion);
                this.save_answer();
                $('#processing').html('Processing...<br />');
                
                window.setTimeout(function(){
                        window.location = quiz.submitUrl;
                }, 3000);
        },
        word_count: function(value, count) {
                var wordCount = value.length;
                if (wordCount == '') {
                        wordCount = 0;
                }
                $('#' + count).html(wordCount);
        }
}

var question = {
        position: 'Up',
        quizId: '0',
        questionId: '0',
        positionNo: '0',
        cancel_move: function(position, quizId, questionId, positionNo) {
                this.position = position;
                this.quizId = quizId;
                this.questionId = questionId;
                this.positionNo = positionNo;
                
                $('#move-text').html('Please enter where to move Q#'+questionId+ ' of position # ' + positionNo + ' ' + position + ' to');
                
                if (position == 'Up') {
                        newPos = this.positionNo - 1;
                } else {
                        newPos = this.positionNo + 1;
                }
                
                $('#position').val(newPos);
                
                if ($('#warning').css('display') == 'none') {
                        $('#warning').removeClass('hide');
                } else {
                        $('#warning').addClass('hide');
                }
        },
        move: function() {
                var position = parseInt($('#position').val());
                
                if (this.position == 'Up') {
                        newPos = this.positionNo - position;
                } else {
                        newPos = position - this.positionNo;
                }
                
                var data = {
                        quizId: this.quizId,
                        questionId: this.questionId,
                        newPos: newPos,
                        position: this.position
                }

                $.ajax({
                        type: 'GET',
                        url:'/admin/recruitment/quizzes/move_question',
                        data: data,
                        success: function() {
                                window.location = '/admin/recruitment/quizzes/edit/' + question.quizId;
                        }
                });
        }
}


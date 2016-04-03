var checkUsernameTimer;

window.onload = function() {
    global();
    
    $('[data-toggle="tooltip"]').tooltip(); 
    
    $('li.active').removeClass('active');
    $("#indexMenuItem").addClass('active');
    
    if (sessionStorage.loggedIn == 'true') {
        $("#signupForm").hide();
        $("#promotions").after($("#liveStats"));
    } else {
        $("#signupForm").show();
        $("#signupForm").after($("#liveStats"));
    }
    
    $("#userRegisterUsername").on({
        input: function() {
            checkUsernameTimer = setTimeout(checkUsername, 500);
        }
    });
    
    updateLiveStats();
    setTimeout(updateLiveStats, 5000);
    addPromotions();
    addTestimonials();
}

function checkUsername() {
    $.post('./php/users/checkusername.php', {
        username: $("#userRegisterUsername").val()
    }, function(response) {
        if (response == 'exists') {
            $("#userRegisterUsername").css('border', red);
        } else if (response == 'notexists') {
            $("#userRegisterUsername").css('border', green);
        } else {
            alert('Error checking if username exists');
        }
    }).fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with checkusername function");
    });
}

function updateLiveStats() {
    $.post('./php/users/getlivestats.php', {}, 
    function(response) {
        var timeLive = '';
        var t = response[1];
        if (response[1] > 365) {
            timeLive = Math.floor(t / 365) + ' year' + (t > 730 ? 's' : '');
        } else if (response[1] > 30) {
            timeLive = Math.floor(t / 30) + ' month' + (t > 60 ? 's' : '');
        } else {
            timeLive = Math.floor(t) + ' day' + (t > 2 ? 's' : '');
        }
        
        $("#liveStatsRegisteredUserValue").text(response[0]);
        $("#liveStatsPlayingSinceValue").text(timeLive);
        $("#liveStatsTournamentPrizeValue").text('₹' + response[2]);
        $("#liveStatsLiveQuizzesValue").text(response[3]);
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with updateLiveStats function");
    });
}

function addPromotions() {
    $.post('./php/promotions/getallpromotions.php', {
        
    }, function(response) {
        if (response[0] == 'success') {
            var html = '';
            html += '<div class="carousel-inner" role="listbox">';

            for (var i = 0; response[1] != null && i < response[1].length; i += 1) {
                html += '    <div class="item active">';
                html += '        <a href="quizinfo.php?id=' + response[1][i].quizID + '">';
                html += '            <img src="./php/promotions/uploads/' + response[1][i].imageURL + '" class="img-responsive">';
                html += '        </a>';
                html += '    </div>';
            }

            html += '</div>';

            $("#promotionCarousel").empty().append(html);

            if (response.length == 0) { $("#promotions").hide(); }
        } else {
            alert("Promotions failed to load.")
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with addPromotions function");
    });
}

function addTestimonials() {
    $.post('./php/testimonials/getalltestimonials.php', {
        
    }, function(response) {
        if (response[0] == 'success') {
            var html = '';
            html += '<div class="carousel-inner" role="listbox">';

            for (var i = 0; response[1] != null && i < response[1].length; i += 1) {
                html += '<div class="item">';
                html += '    <blockquote>';
                html += '        <p>' + response[1][i].message + '</p>';
                html += '        <footer>' + response[1][i].username + '</footer>';
                html += '    </blockquote>';
                html += '</div>';
            }

            html += '</div>';

            $("#testimonialCarousel").empty().append(html);
            $("#testimonialCarousel > div > :nth-child(1)").addClass('active');

            if (response.length == 0) { $("#testimonials").hide(); }
        } else {
            alert("Testimonials failed to load.")
        }
    }, 'json').fail(function (request, textStatus, errorThrown) {
        alert("Error: Something went wrong with addPromotions function");
    });
}

function resetGame () {
    resetUI();
    chooseWord();
}
$(document).ready(resetGame);
function win () {
    alert('You won man!');
    $.getJSON ("update_score.php?score="+ $possiblePoints);
    resetGame();
}
function lose () { alert('Dude you lost, the word was ' + gameAnswer); resetGame(); }
function doKeypress () {
    var tempChar = $('#letter-input').val().toLowerCase();
    var tempString = "";
    $('#letter-input').val("");

    // Write here!
    tempString = guessLetter( tempChar, gameShownAnswer, gameAnswer );
    if ( tempString != gameShownAnswer ) {
        updateWord( tempString );
        gameShownAnswer = tempString;
        if ( gameShownAnswer === gameAnswer ) {
            win();

        }
    } else {
        wrongLetter(tempChar);
        drawSequence[ hangmanState++ ]();
        if ( hangmanState === drawSequence.length ) {
            lose();
        }
    }
}
$('#letter-input').keyup( doKeypress );
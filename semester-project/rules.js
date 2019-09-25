var easyWords = ['cat', 'dog', 'tree', 'mouse'];
var intermediateWords = ['fragile', 'zebra', 'rectify', 'chimichanga'];
var hardWords = ['awkward', 'fervid', 'dwarves', 'croquet'];
var $possiblePoints = 0;
$(document).ready(function() {
    $('input[type=radio][name=difficulty]').change(function () {
        resetGame();
    })
});

function chooseWord () {
    $selection = $('input[name=difficulty]:checked').val();
    $.getJSON("get_word.php?difficulty=" + $selection, function (data) {
        gameAnswer = data.word;
        gameShownAnswer = blanksFromAnswer(gameAnswer);
        hangmanState = 0;
        drawWord(gameShownAnswer);
        if ($selection === 'hard') {
            $possiblePoints = 3;

        }
        else if ($selection === "intermediate") {
            $possiblePoints = 2;

        }
        else if ($selection === "easy") {
            $possiblePoints = 1;

        }
    });
    }

function blanksFromAnswer ( answerWord ) {
    var result = "";
    for ( i in answerWord ) {
        result = "_" + result;
    }
    return result;
}
function alterAt ( n, c, originalString ) {
    return originalString.substr(0,n) + c + originalString.substr(n+1,originalString.length);
}
function guessLetter( letter, shown, answer ) {
    var checkIndex = 0;

    checkIndex = answer.indexOf(letter);
    while ( checkIndex >= 0 ) {
        shown = alterAt( checkIndex, letter, shown );
        checkIndex = answer.indexOf(letter, checkIndex + 1);
    }
    return shown;
}
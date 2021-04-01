
Survey.defaultBootstrapMaterialCss.navigationButton = "btn btn-green";
Survey.defaultBootstrapMaterialCss.rating.item = "btn btn-default my-rating";
Survey
    .StylesManager
    .applyTheme("bootstrapmaterial");

var json = {
    pages: [
        {
            questions: [
                {
                    type: "matrix",
                    name: "Quality",
                    title: "Please indicate if you agree or disagree with the following statements",
                    columns: [
                        {
                            value: 1,
                            text: "Strongly Disagree"
                        }, {
                            value: 2,
                            text: "Disagree"
                        }, {
                            value: 3,
                            text: "Neutral"
                        }, {
                            value: 4,
                            text: "Agree"
                        }, {
                            value: 5,
                            text: "Strongly Agree"
                        }
                    ],
                    rows: [
                        {
                            value: "fun",
                            text: "I had fun today participating"
                        }, {
                            value: "learn",
                            text: "I learnt something new today"
                        }, {
                            value: "organization",
                            text: "I am satisfied with the overall organization of the event"
                        }, {
                            value: "redo",
                            text: "I will participate again in a similar event"
                        }, {
                            value: "support",
                            text: "I had adequate support from the AWS team"
                        }

                    ]
                },
		{
            "type": "boolean",
            "name": "continueProject",
            "title": "...",
            "label": "Would you been keen to continue working on your project?",
            "isRequired": true
        	},
                {
                    type: "comment",
                    name: "suggestions",
                    title: "What would make this event is better or more fun?"
                }
            ]
        }
    ]
};

window.survey = new Survey.Model(json);

survey
    .onComplete
    .add(function (result) {
        document
            .querySelector('#surveyResult')
            .value = JSON.stringify(result.data, null, 3);
 	$.post('index.php', $('#frm').serialize(), function(r) { console.log(r); });
    });

$("#surveyElement").Survey({model: survey});

class wohnratingForm {
    constructor() {
        this.questions = undefined
        this.questionNumber = undefined
        this.questionContainer = undefined
        this.question = undefined
        this.questionDOMnumber = undefined
        this.questionsTotal = undefined
        this.questionDOMtotal = undefined
        this.nextText = undefined
        this.skipText = undefined
    }

    init() {
        this.questions = {
            1 : {
                "question" : "Haben Sie der eidgenössischen Initiative «Mehr bezahlbare Wohnungen» (Abstimmung vom 9. Februar 2020), die das Ziel verfolgte, das Angebot an preisgünstigem Wohnraum zu erhöhen, zugestimmt?",
                "response" : 0
            },
            2 : {
                "question" : "Würden Sie sich dafür einsetzen, dass in ihrer Gemeinde Zonen für preisgünstiges Wohnen (nach Artikel 49b des Planungs- und Baugesetzes) errichtet werden? Dadurch wird ein Mindestanteil an preisgünstigem Wohnraum festgelegt und die höchstzulässigen Mietzinse werden festgesetzt.",
                "response" : 0
            },
            3 : {
                "question" : "Der gemeinnützige Wohnungsbau orientieren sich an der Kostenmiete und wirtschaftet ohne Gewinnabsichten. Ist in Ihrer Gemeinde ein höherer Anteil an gemeinnützigen Wohnungen wünschenswert?",
                "response" : 0
            },
            4 : {
                "question" : "Würden Sie es befürworten, wenn ihre Gemeinde bei Landverkäufen oder der Einrichtung eines Baurechts prinzipiell gemeinnützige Wohnbauträger berücksichtigt?",
                "response" : 0
            },
            5 : {
                "question" : "Wohnbaugenossenschaften bringen einen breiten volkswirtschaftlichen Nutzen, in dem Sie z.B. auf eine gute Belegung der Wohnungen achten, in ökologische Massnahmen investieren und besonders in den Städten auch Familien halten und zu einer guten und stabilen sozialen Durchmischung beitragen. Können Sie dieser Aussage zustimmen?",
                "response" : 0
            },
            6 : {
                "question" : "Der Regionalverband Wohnbaugenossenschaften Zürich hat eine kantonale Initiative lanciert, die es den Gemeinden erlauben würde, ein Vorkaufsrecht zu etablieren. Unterstützen Sie diese Initiative?",
                "response" : 0
            },
            7 : {
                "question" : "Braucht es künftig ein «Wohnschutzgesetz», das die Mieter*innen vor Leerkündigungen und preistreibenden Renovationen schützt? Ist es Aufgabe der Regierung Anreize zu schaffen, dass Immobilienbesitzer*innen Sanierungen im bewohnten Zustand vornehmen, so dass die Mieter*innen in den Wohnungen bleiben können, oder ein Rückkehrrecht erhalten, nachdem die Wohnungen saniert oder umgebaut wurden?",
                "response" : 0
            },
            8 : {
                "question" : "Verschiedene parlamentarische Initiativen zielen darauf ab, die Anfechtung des Anfangsmietzinses zu schwächen indem eine Einschränkung auf persönliche/familiäre Notsituationen und eine Verstärkung der Orts- und Quartierüblichkeit gefordert wird. Unterstützen Sie diese Bestrebungen?",
                "response" : 0
            },
            9 : {
                "question" : "Soll der Kündigungsschutz wegen Eigenbedarf vereinfacht werden, damit Eigentümer*innen besser über ihre Liegenschaften verfügen können?",
                "response" : 0
            },
            10 : {
                "question" : "Müssen sich ältere Menschen, Personen mit kleinem Budget, vielen Kindern, in Ausbildung etc. insbesondere in den grösseren Städten Sorgen machen, wenn Sie sich auf Wohnungssuche begeben müssen? Sind die Gemeinden gefordert, hier unterstützend einzuschreiten?",
                "response" : 0
            },
            11 : {
                "question" : "Erachten Sie es als Aufgabe ihrer Gemeinde, für bezahlbaren Wohnraum für ältere Menschen, Personen mit kleinem Budget, vielen Kindern oder in Ausbildung zu sorgen?",
                "response" : 0
            },
        }
        this.questionsTotal = Object.keys(this.questions).length
        this.questionNumber = 1
        this.questionContainer = document.getElementById("question-container")
        this.questionDOMnumber = document.getElementById("question-number")
        this.questionDOMtotal = document.getElementById("question-total")
        this.questionDOMtotal.innerHTML = this.questionsTotal
        this.question = document.getElementById("question")
        this.setQuestion(this.questionNumber)
    }

    setQuestion(number) {
        document.querySelectorAll(".button.choice").forEach((choice) => {
            choice.classList.remove("chosen")
        })
        if (this.questionNumber < this.questionsTotal) {
            this.skipText = "Überspringen"
        } else {
            this.skipText = "Umfrage abschliessen"
        }
        document.getElementById("nextquestion").innerHTML = this.skipText

        setTimeout(() => {
            
            this.questionContainer.setAttribute("data-question-number", number)
            this.question.innerHTML = this.questions[number]["question"]
            this.questionDOMnumber.innerHTML = number
            
            this.questionContainer.classList.add("active")

            if (this.questionNumber < this.questionsTotal) {
                this.nextText = "Nächste Frage"
            } else {
                this.nextText = "Umfrage abschliessen"
            }
        }, 250);
        

    }

    pickAnswer(answer) {
        if (answer.classList.contains("chosen")) {
            answer.classList.remove("chosen")
            document.getElementById("nextquestion").innerHTML = "Überspringen"
        } else {
            document.querySelectorAll(".button.choice").forEach((choice) => {
                choice.classList.remove("chosen")
            })
            answer.classList.add("chosen")
            document.getElementById("nextquestion").innerHTML = this.nextText
        }
    }

    answerQuestion() {
        var choice = document.querySelector(".button.choice.chosen")
        if (choice !== null) {
            choice = parseInt(choice.getAttribute("data-response-value"))
        } else {
            choice = "NA"
        }
        this.questions[this.questionNumber]["response"] = choice
        if (this.questionNumber != this.questionsTotal) {
            document.getElementById("question-container").classList.add("done")
            setTimeout(() => {
                document.getElementById("question-container").classList.remove("active")
                document.getElementById("question-container").classList.remove("done")
                this.questionNumber = this.questionNumber + 1
                this.setQuestion(this.questionNumber)
            }, 750);
        } else {
            var response = { "politId" : document.getElementById("question-container").getAttribute("data-polit-id"), "questions" : this.questions}
            fetch("/umfrage/submit", {
                method: "POST", 
                body: JSON.stringify(response)
            }).then(res => {
                return res.text();
            }).then(text => {
                text = JSON.parse(text)
                if (text.code == 200) {
                    window.location.href="/danke"
                } else {
                    alert(text.text)
                }
            })
        }
    }



    start() {window.addEventListener("DOMContentReady", this.init())}

}

const form = new wohnratingForm()

form.start()
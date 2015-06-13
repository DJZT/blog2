(function(){
	window.App = {
		Models: {},
		Views: {},
		Collections: {},
		Router: {}
	};

	App.Router = Backbone.Router.extend({
		routes: {
			'' : 'index',
			'index' : 'index',
			'add': 'addQuestion',
			'edit/:id': 'editQuestion'
		},

		index: function(){
			if (!CollectionQuestion.length) {
				// CollectionQuestion 	= new App.Collections.Questions(questions);
				CollectionQuestion 	= new App.Collections.Questions();
				CollectionQuestion.fetch();
				GlobalWidget 		= new App.Views.Questions({collection: CollectionQuestion});
				$('#CollectionQuestion').append(GlobalWidget.render().el);
				addQuestionView = new App.Views.AddQuestion({collection: CollectionQuestion});
			};

			$('.modal').modal('hide');
		},
		addQuestion: function(){
			// if (!CollectionQuestion.length) {
			// 	this.index();
			// };


			ViewAdd = new App.Views.AddQuestion();
			ViewAdd.render().showe();
			// $('#addQuestionModal').modal();
		},
		editQuestion: function(id){
			if (!CollectionQuestion.length) {
				this.index();
			};

			var model = CollectionQuestion.get(id);
			// console.log(model);

			// $('#editQuestionModal').on('show.bs.modal', function (event) {
			// 	var modal = $(this);
			// 	modal.find('textarea').val(model.get('question'));
			// }).modal();
		}
	});


	// Модель ответа
	App.Models.Answer = Backbone.Model.extend({
		urlRoot: 'tests/rest/answer'
	});


	// Модель вопроса
	App.Models.Question = Backbone.Model.extend({
		defaults: {
			
			question: "",
			id_theme: 0,
			multi_answer: false,
			ids_answers: [],
			answers: []
		},
		urlRoot: '/tests/rest/question',
		initialize: function(){
			this.attributes.answers = new App.Collections.Answers();
			for (var i = 0; i < this.attributes.ids_answers.length; i++) {
				this.attributes.answers.add(new App.Models.Answer({id: this.attributes.ids_answers[i]}));
			};
			
		},
		validate: function (attrs) {
			if (  $.trim(attrs.title) ) {
				return 'Вопрос должен быть правильным';
			}
		}
	});


	// Модель коллекции вопросов
	App.Collections.Questions = Backbone.Collection.extend({
		model: App.Models.Question,
		url: '/tests/rest/question'
	});

	// Модель коллекции ответов
	App.Collections.Answers = Backbone.Collection.extend({
		model: App.Models.Answer,
		url: '/tests/rest/answer'
	});


	// Виджет вопроса
	App.Views.Question = Backbone.View.extend({
	    tagName: "tr",
	    template: "",
	    templateUrl: function(){
	    	return "localhost/tests/views/models/question";
	    },
	    getTemplate: function(){
	    	
	    },

	    className: function(){
	    	if (this.model.get('multi_answer')) {
	    		return 'list-group-item-success';
	    	}else{
	    		return 'list-group-item-danger';
	    	}
	    	
	    },

	    initialize: function(){
	    	this.renderTemplate = _.template($('#QuestionTemplate').html());
	    	// Перерисовка вида при изменении модели
	    	this.model.on('change', this.render, this); 
	    },

	    render: function () {
	       	this.$el.html(this.renderTemplate(this.model.toJSON()));
	        // console.log(this.el);
	        return this;
	    },

	    events: {
			'click .edit' : 'editQuestion'
		},
		editQuestion: function(){
			// console.log(this.model.toJSON());
			var EditView = new App.Views.EditQuestion({model: this.model});

			EditView.render();
			// console.log(EditView);
			EditView.showe();

			// var newQuest = prompt('Как переименуем quest?', this.model.get('question'));
			// this.model.set('question', newQuest);
		}
	});


	// Виждет списка вопросов
	App.Views.Questions = Backbone.View.extend({
	    tagName: "tbody",
	    className: "",

	    initialize: function(){
	    	this.collection.on('add', this.addOne, this);
	    },

	    render: function () {
	    	this.collection.each(this.addOne, this);
	    	return this; 
	    },

	    addOne: function (que) {
	    	// создавать новый дочерний вид
            var QuestionView = new App.Views.Question({ model: que });
            // добавлять его в корневой элемент
            this.$el.append(QuestionView.render().el);
	    }
	});

	// Виджет списка ответов
	App.Views.Answers = Backbone.View.extend({
		

	});

	// Виджет добавления вопроса
	App.Views.AddQuestion = Backbone.View.extend({
		el: "#addQuestion",
		events: {
			'submit':'submit'
		},

		initialize: function(){
			this.template = _.template($('#QuestionAddTemplate').html());
		},
		render: function(){
			$('body').append(this.template);
			return this;
		},
		showe: function(){
			$('#addQuestionModal').modal();
			return this;
		},
		submit: function(e){
			e.preventDefault();
			// var NewMulti 	= $(e.currentTarget).find('input[name=multi_answer]').val();
			
			var newQuestion = new App.Models.Question({
				question: $('textarea[name=question]').val(),

			});
			newQuestion.save();
			// console.log(newQuestion);
			this.collection.add(newQuestion);

		}
	});

	// Виджет редактирования вопроса
	App.Views.EditQuestion = Backbone.View.extend({
		el: "#editQuestion",
		events: {
			'submit':'submit'
		},

		initialize: function(){
			this.template = _.template($('#QuestionEditTemplate').html());
		},
		render: function(){
			$('body').append(this.template(this.model.toJSON()));
			return this;
		},
		showe: function(){
			$('#editQuestionModal').modal();
			return this;
		},
		submit: function(e){
			// e.preventDefault();
			// // var NewMulti 	= $(e.currentTarget).find('input[name=multi_answer]').val();
			
			// var newQuestion = new App.Models.Question({
			// 	question: $('textarea[name=question]').val(),

			// });
			// newQuestion.save();
			// // console.log(newQuestion);
			// this.collection.add(newQuestion);

		}
	});


	$(document).ready(function(){
		new App.Router();
		Backbone.history.start();
	});

}());



   

	



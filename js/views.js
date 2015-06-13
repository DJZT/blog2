/*
/ Global App View
*/

App.Views.App = Backbone.View.extend({
	initialize: finction(){
		console.log(this.collection.toJSON());
	}
});
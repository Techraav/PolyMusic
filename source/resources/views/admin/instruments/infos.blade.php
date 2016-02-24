<div class="jumbotron">
	<h1>Gestion des instruments</h1>
	<p>Les instruments sont nécessaires à la création de cours et de membres de groupes, pour les classer par instrument.</p>
	<p>Il ne s'agit que d'une simple liste de noms d'instruments référencés sur votre site.</p>
	<p>Il est nécessaire d'être au minimum <b>{{ ucfirst(App\Level::where('level', 3)->first()->name) }}</b> supprimer un instrument qui est &laquo; utilisé &raquo; par au moins un cours ou un membre d'un groupe</p>
</div>
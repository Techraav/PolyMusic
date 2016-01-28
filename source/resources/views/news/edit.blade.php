{{-- 
	(Quasi pareil que pour create.blade.php)

	Formulaire pour modifier une news
	Les champs contiennent les données déja enregistrées (si tu sais pas comment récuperer les données je te guide un peu pour l'index)
	Tu peux regarder la gestion des erreurs (tape withErrors dans la barre de recherche de la doc) pour des erreurs plus ciblées (que le controller envoie si il y en a). hf
	Pour le formulaire : 
	Les données que j'attends : utilise les name suivants : title (input text), content (textarea), active (une checkbox, cochée si la news est active ($news->active == 1 ?) (ca se fait en html)) 
	rajoute la propriété required sur les inputs pour que ca bloque si c'est pas rempli

--}}
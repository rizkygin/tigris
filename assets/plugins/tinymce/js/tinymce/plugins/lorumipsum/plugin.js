tinymce.PluginManager.add('lorumipsum', function(editor, url) {
    // Add a button
    editor.ui.registry.addIcon('lorum', '<svg width="16" height="16"><path d="M13.5 0h-12c-0.825 0-1.5 0.675-1.5 1.5v13c0 0.825 0.675 1.5 1.5 1.5h12c0.825 0 1.5-0.675 1.5-1.5v-13c0-0.825-0.675-1.5-1.5-1.5zM13 14h-11v-12h11v12zM4 7h7v1h-7zM4 9h7v1h-7zM4 11h7v1h-7zM4 5h7v1h-7z"></path></svg>');
    editor.ui.registry.addButton('lorumipsum', {
		icon: 'lorum',
		//text: 'lorem ipsum',
		tooltip: 'lorem ipsum text',
        onAction: function() {
		editor.insertContent('<h1>Tu enim ista lenius, hic Stoicorum more nos vexat.</h1><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nihilo magis. Primum quid tu dicis breve? <b>Maximus dolor, inquit, brevis est.</b>Quod quidem iam fit etiam in Academia.</mark><i>Que Manilium, ab iisque M.</i> Sed residamus, inquit, si placet. Duo Reges: constructio interrete. Sed tamen omne, quod de re bona dilucide dicitur, mihi praeclare dici videtur. Hunc vos beatum; Habes, inquam, Cato, formam eorum, de quibus loquor, <a href="#">philosophorum</a>.</p><h2>Quam ob rem tandem, inquit, non satisfacit?</h2><p>Nam memini etiam quae nolo, oblivisci non possum quae volo. Octavio fuit, cum illam severitatem in eo filio adhibuit, quem in adoptionem D. Est, ut dicis, inquam. </p><blockquote cite="http://loripsum.net">Epicurus autem cum in prima commendatione voluptatem dixisset, si eam, quam Aristippus, idem tenere debuit ultimum bonorum, quod ille;</blockquote><ol><li>Illud non continuo, ut aeque incontentae.</li><li>Vide, quantum, inquam, fallare, Torquate.</li><li>Laelius clamores sof&ograve;w ille so lebat Edere compellans gumias ex ordine nostros.</li></ol><p>Nam, ut sint illa vendibiliora, haec uberiora certe sunt. Dicam, inquam, et quidem discendi causa magis, quam quo te aut Epicurum reprehensum velim. Nam adhuc, meo fortasse vitio, quid ego quaeram non perspicis. Videsne quam sit magna dissensio? Sin dicit obscurari quaedam nec apparere, quia valde parva sint, nos quoque concedimus; Non dolere, inquam, istud quam vim habeat postea videro; Ut nemo dubitet, eorum omnia officia quo spectare, quid sequi, quid fugere debeant? Dulce amarum, leve asperum, prope longe, stare movere, quadratum rotundum. </p><p>Quamquam tu hanc copiosiorem etiam soles dicere. Si quidem, inquit, tollerem, sed relinquo. Mihi enim satis est, ipsis non satis. <b>Quod totum contra est.</b> Huic mori optimum esse propter desperationem sapientiae, illi propter spem vivere. Nunc ita separantur, ut disiuncta sint, quo nihil potest esse perversius. <i>Tum Triarius: Posthac quidem, inquit, audacius.</i> </p><h3>Quaerimus enim finem bonorum.</h3><p>Quae fere omnia appellantur uno ingenii nomine, easque virtutes qui habent, ingeniosi vocantur. <i>Hoc sic expositum dissimile est superiori.</i> Ratio enim nostra consentit, pugnat oratio. Obsecro, inquit, Torquate, haec dicit Epicurus? </p><ul><li>Sed finge non solum callidum eum, qui aliquid improbe faciat, verum etiam praepotentem, ut M.</li><li>Non pugnem cum homine, cur tantum habeat in natura boni;</li><li>Unum nescio, quo modo possit, si luxuriosus sit, finitas cupiditates habere.</li><li>Nunc de hominis summo bono quaeritur;</li></ul>');
        }
    });
});






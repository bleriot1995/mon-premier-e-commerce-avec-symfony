$('#add-image').click(function () { // Je recupere le numéro des futurs champs que je vais créer
    const index = + $('#widgets-counter').val();

    // Je recupère le protype des entées
    const tmpl = $('#ad_images').data('prototype').replace(/_name_/g, index);
    // j'injecte ce code au sein de la div
    $('#ad_images').append(tmpl);
    $('#widgets-counter').val(index + 1);

    // je veux gere le bouton supprimer

    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function () {

        const target = this.dataset.target
        $(target).remove();

    });

}

function updateCounter() {
    const count = + $('#ad_images div.form-group').length;
    $('#widgets-counter').val(count);
}
updateCounter();
handleDeleteButtons();
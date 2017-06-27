$(document).ready(function(){
    var $collectionHolder;

    // setting up add Tags block in DOM
    var $addTagLink = $('<a href="#" class="add_tag_link">Add a tag</a>');
    var $newLinkLi = $('<li></li>').append($addTagLink);
    $collectionHolder = $('ul.tags');

    // add the add a Tag anchor and li to the target ul
    $collectionHolder.append($newLinkLi);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e){
        e.preventDefault();

        addTagForm($collectionHolder, $newLinkLi);
    });
    function addTagForm($collectionHolder, $newLinkLi){
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');

        // Replace _name_ in the prototype's html to instead a number based on how many items there is
        var newForm = prototype.replace(/__name__/g, index);
        //increasing the index accordingly with the number of tags
        $collectionHolder.data('index', index+1);

        // Adding new form in a li before 'add a tag'
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi)
    }
});
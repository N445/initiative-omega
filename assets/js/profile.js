import './../styles/profile.scss';
import 'select2';

const addTagFormDeleteEvent = (item) => {
    $(item).find('.btn-remove-fleet').on('click', (e) => {
        e.preventDefault();
        item.remove();
    });
}


function formatState(state) {
    if(!state.id) {
        return state.text;
    }
    return $(
        `<span>
            <img src="${$(state.element).attr('data-ship-banner')}" class="img-fluid select2-ship-image d-block mx-auto" width="150" loading="lazy"/>
            ${state.text}
        </span>`,
    );
}

const addSelect2 = (item) => {
    $(item).find('select').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        templateResult: formatState,
    }).on('change', function (e) {
        $(item)
            .find(`.card-img-top`)
            .attr('src', $(item)
                .find(`select option[value="${$(this).val()}"]`)
                .attr('data-ship-banner'),
            );
    });
}

const addPlusMinusQuantity = (item) => {
    $(item).find('.add-quantity').on('click', function () {
        let input = $(item).find('.number-ships input');
        let currentVal = parseInt(input.val());
        input.val(currentVal + 1).change();
    })

    $(item).find('.remove-quantity').on('click', function () {
        let input = $(item).find('.number-ships input');
        let currentVal = parseInt(input.val());
        if(currentVal > input.attr('min')) {
            input.val(currentVal - 1).change();
        }
    })
}

const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('div');

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index,
        );

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
    addTagFormDeleteEvent(item);
    addSelect2(item);
    addPlusMinusQuantity(item);
};


document.querySelectorAll('.add_item_link').forEach(btn => {
        btn.addEventListener("click", addFormToCollection)
    });

document.querySelectorAll('.fleets-form .fleet').forEach((fleet) => {
        addTagFormDeleteEvent(fleet)
        addSelect2(fleet)
        addPlusMinusQuantity(fleet);
    })

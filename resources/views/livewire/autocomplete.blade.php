<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />


<input name='users_list_tags' id="users-list-tags" class="w-full rounded border border-gray-800" value='abatisse2@nih.gov, Justinian Hattersley'>


<script>
    var inputElm = document.querySelector('input[name=users_list_tags]');

function tagTemplate(tagData){
    return `
        <tag title="${tagData.email}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="tagify__tag ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div>
                <div class='tagify__tag__avatar-wrap'>
                    <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                </div>
                <span class='tagify__tag-text'>${tagData.name}</span>
            </div>
        </tag>
    `
}

function suggestionItemTemplate(tagData){
    return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            ${ tagData.avatar ? `
            <div class='tagify__dropdown__item__avatar-wrap'>
                <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
            </div>` : ''
            }
            <strong>${tagData.name}</strong>
            <span>${tagData.email}</span>
        </div>
    `
}

function dropdownHeaderTemplate(suggestions){
    return `
        <div class="${this.settings.classNames.dropdownItem} ${this.settings.classNames.dropdownItem}__addAll">
            <strong>${this.value.length ? `Agregar a los ${suggestions.length} restantes` : 'Agregar a todos'}</strong>
            <span>${suggestions.length} members</span>
        </div>
    `
}

// initialize Tagify on the above input node reference
var tagify = new Tagify(inputElm, {
    tagTextProp: 'name', // very important since a custom template is used with this property as text
    // enforceWhitelist: true,
    skipInvalid: true, // do not remporarily add invalid tags
    userInput: false,
    dropdown: {
        closeOnSelect: false,
        enabled: 0,
        classname: 'users-list',
        searchKeys: ['name', 'email']  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: tagTemplate,
        dropdownItem: suggestionItemTemplate,
        dropdownHeader: dropdownHeaderTemplate
    },
    whitelist: [
    
            @php
                $followedIds = App\Models\Following::select('target_id')->where('target_type', 'user')
        ->where('follower_id', Auth::guard('web')->user()->id)->get();

        $followedUsers = App\Models\User::whereIn('id', $followedIds)->get();
            @endphp
            @foreach ($followedUsers as $followedUser)
            {
            "value": "{{$followedUser->username}}",
            "name": "{{$followedUser->name}}",
            "avatar": "{{$followedUser->profile_photo_path}}",
            "email": "{{$followedUser->email}}"
        },
            @endforeach
    ],
    transformTag: (tagData, originalData) => {
        var {name, email} = parseFullValue(tagData.name)
        tagData.name = name
        tagData.email = email || tagData.email
    },
    validate({name, email}) {
        // when editing a tag, there will only be the "name" property which contains name + email (see 'transformTag' above)
        if( !email && name ) {
            var parsed = parseFullValue(name)
            name = parsed.name
            email = parsed.email
        }

        if( !name ) return "Missing name"
        if( !validateEmail(email) ) return "Invalid email"

        return true
    }
})

// attach events listeners
tagify.on('dropdown:select', onSelectSuggestion) // allows selecting all the suggested (whitelist) items
      .on('edit:start', onEditStart)  // show custom text in the tag while in edit-mode

function onSelectSuggestion(e){
    // custom class from "dropdownHeaderTemplate"
    if( e.detail.elm.classList.contains(`${tagify.settings.classNames.dropdownItem}__addAll`) )
        tagify.dropdown.selectAll();
}

function onEditStart({detail:{tag, data}}){
    tagify.setTagTextNode(tag, `${data.name} <${data.email}>`)
}

// https://stackoverflow.com/a/9204568/104380
function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
}

function parseFullValue(value) {
    // https://stackoverflow.com/a/11592042/104380
    var parts = value.split(/<(.*?)>/g),
        name = parts[0].trim(),
        email = parts[1]?.replace(/<(.*?)>/g, '').trim();

    return {name, email}
}
</script>
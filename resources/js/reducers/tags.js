const initialState = [
    {
        "id": 1,
        "title": "testtag",
        "created_at": "2020-05-31 18:53:32",
        "updated_at": "2020-05-31 18:53:32",
        "link": "http://0.0.0.0/tags/testtag"
    },
    {
        "id": 2,
        "title": "DictaReiciendisQuisReiciendisRepellatSitNisiAnimiDoloremque",
        "created_at": "2020-05-31 18:53:33",
        "updated_at": "2020-05-31 18:53:33",
        "link": "http://0.0.0.0/tags/DictaReiciendisQuisReiciendisRepellatSitNisiAnimiDoloremque"
    },
    {
        "id": 3,
        "title": "Alias",
        "created_at": "2020-05-31 18:53:33",
        "updated_at": "2020-05-31 18:53:33",
        "link": "http://0.0.0.0/tags/Alias"
    }
];

const reducer = (state = initialState, action) => {
    switch (action.type) {
        default:
            return state;
    }
};

export default reducer;
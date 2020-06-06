const initialState = [
    {
      "id": 1,
      "name": "admin",
      "slug": "admin",
      "image": "https://lorempixel.com/120/120/?40400",
      "banner": "https://lorempixel.com/640/160/?60576",
      "description": "Est quia quos et qui eum eos. A est distinctio enim distinctio qui itaque voluptatibus. Amet harum consequatur incidunt dignissimos.",
      "pinned_post_id": null,
      "created_at": "2020-05-31 18:53:32",
      "updated_at": "2020-05-31 18:53:32"
    },
    {
      "id": 2,
      "name": "testuser",
      "slug": "testuser",
      "image": "https://lorempixel.com/120/120/?14081",
      "banner": "https://lorempixel.com/640/160/?68438",
      "description": "Quo adipisci est ut error aut molestiae provident id. Et asperiores nisi sunt vel nobis molestias quia. Neque pariatur qui doloremque autem temporibus mollitia.",
      "pinned_post_id": 1,
      "created_at": "2020-05-31 18:53:32",
      "updated_at": "2020-05-31 18:53:32"
    },
    {
      "id": 3,
      "name": "Darius Gleason",
      "slug": "darius-gleason",
      "image": "https://lorempixel.com/120/120/?27987",
      "banner": "https://lorempixel.com/640/160/?45414",
      "description": "Amet occaecati et et odio error ab. Nihil commodi voluptates dolor maxime laborum hic. Voluptatem voluptas excepturi omnis animi. Velit magnam libero tempore ut qui porro.",
      "pinned_post_id": null,
      "created_at": "2020-05-31 18:53:32",
      "updated_at": "2020-05-31 18:53:32"
    }
];

const reducer = (state = initialState, action) => {
    switch (action.type) {
        default:
            return state;
    }
};

export default reducer;
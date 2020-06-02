
const initalState = [
    {
        id: 1,
        title: 'Title 1',
        excerpt: 'Excerpt 1',
        created_at: '10.02.19',
        like_count: 14,
        bookmark_count: 9,
    },
    {
        id: 2,
        title: 'Title 2',
        excerpt: 'Excerpt 2',
        created_at: '10.02.19',
        like_count: 30,
        bookmark_count: 21,
    },
    {
        id: 3,
        title: 'Title 3',
        excerpt: 'Excerpt 3',
        created_at: '10.02.19',
        like_count: 50,
        bookmark_count: 3,
    },
    {
        id: 4,
        title: 'Title 4',
        excerpt: 'Excerpt 4',
        created_at: '10.02.19',
        like_count: 51,
        bookmark_count: 22,
    }
];

const reducer = (state = initalState, action) => {
    switch (action.type) {
        default:
            return state;
    }
};

export default reducer;

const action = (type, initialData) => (state = {
    loading: true,
    data: initialData || [],
}, action) => {
    switch (action.type) {
        case `userBookmarkPostIds`:
            return {
                ...state,
                data: {
                    ...state.data,
                    bookmarked_posts: action.payload,
                }
            };
        case `REQUEST/${type}`:
            return {
                ...state,
                loading: true,
            };
        case `OK/${type}`:
            return {
                ...state,
                loading: false,
                data: action.payload,
                error: false,
            };
        case `ERROR/${type}`:
            return {
                ...state,
                error: action.error || true,
                loading: false,
            };
        case `QUERY/${type}`:
            return {
                ...state,
                query: action.query,
            };
        default:
            return state;
    }
};

export default action('metadata');
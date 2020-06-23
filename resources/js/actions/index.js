import action from './action';
import ApiRouter from "../routes/ApiRouter";

export const getMetadata = () => action('metadata', ApiRouter.route('metadata'));

export const getUserProfile = (userId) => action('user', ApiRouter.route('user', [userId]));

export const getUserComments = (userId) => action('userComments', ApiRouter.route('userComments', [userId]));

export const getUserDrafts = (userId) => action('userDrafts', ApiRouter.route('userDrafts', [userId]));

export const getUserBookmarkPosts = (userId) => action('userBookmarkPosts', ApiRouter.route('userBookmarkPosts', [userId]));

export const getCategories = () => action('categories', ApiRouter.route('categories'));

export const getPost = (postId) => action('post', ApiRouter.route('post', [postId]));

export const getCategory = (slug) => action('category', ApiRouter.route('category', [slug]));

export const storeBookmark = (postId) => async (dispatch) => {
    let result = await axios.post(ApiRouter.route('bookmarkStore'), {
        post_id: postId,
    });
    dispatch({type: 'userBookmarkPostIds', payload: result.data});
};

export const deleteBookmark = (postId) => async (dispatch) => {
    let result = await axios.post(ApiRouter.route('bookmarkDelete'), {
        _method: 'delete',
        post_id: postId,

    });
    dispatch({type: 'userBookmarkPostIds', payload: result.data});
};

export const storePostLike = (postId) => async (dispatch) => {
    let result = await axios.post(ApiRouter.route('postLikeStore'), {
        post_id: postId,
    });
    dispatch({type: 'userPostLikeIds', payload: result.data});
};

export const deletePostLike = (postId) => async (dispatch) => {
    let result = await axios.post(ApiRouter.route('postLikeDelete'), {
        _method: 'delete',
        post_id: postId,
    });
    dispatch({type: 'userPostLikeIds', payload: result.data});
};


export const storePostDislike = (postId) => async (dispatch) => {
    let result = await axios.post(ApiRouter.route('postDislikeStore'), {
        post_id: postId,
    });
    dispatch({type: 'userPostDislikeIds', payload: result.data});
};

export const deletePostDislike = (postId) => async (dispatch) => {
    let result = await axios.post(ApiRouter.route('postDislikeDelete'), {
        _method: 'delete',
        post_id: postId,
    });
    dispatch({type: 'userPostDislikeIds', payload: result.data});
};

import Router from './Router';

const apiRouter = new Router({
    metadata: '/api/v1/metadata',

    frontpage:  '/api/v1/page/frontpage/',
    pageNew: '/api/v1/page/new/',
    post: '/api/v1/posts/{postId}',

    user: '/api/v1/users/{userId}/',
    userComments: '/api/v1/users/{userId}/comments',
    userDrafts: '/api/v1/users/{userId}/drafts',
    userBookmarkPosts: '/api/v1/users/{userId}/bookmarks/posts',
    users: '/api/v1/misc/users',

    userBookmarkComments: '/api/v1/users/{userId}/bookmarks/comments',
    category: '/api/v1/categories/{categorySlug}',
    categories: '/api/v1/misc/categories',

    tag: '/api/v1/tags/{tag}',
    tags: '/api/v1/misc/tags',

    bookmarkStore: '/api/v1/bookmarks',
    bookmarkDelete: '/api/v1/bookmarks',

    postLikeStore: '/api/v1/post_likes',
    postLikeDelete: '/api/v1/post_likes',

    postDislikeStore: '/api/v1/post_dislikes',
    postDislikeDelete: '/api/v1/post_dislikes',
}, true, process.env.MIX_APP_API_HOST);

export default apiRouter;
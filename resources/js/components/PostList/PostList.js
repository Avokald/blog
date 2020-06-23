import React, {Component} from 'react';
import {connect} from 'react-redux';
import styled from 'styled-components';
import {Link} from "react-router-dom";
import webRouter from "../../routes/WebRouter";
import {
    deleteBookmark,
    deletePostDislike,
    deletePostLike,
    storeBookmark,
    storePostDislike,
    storePostLike
} from "../../actions";

class PostList extends Component {

    constructor(props) {
        super(props);

        this.bookmarkStore = this.bookmarkStore.bind(this);
        this.bookmarkDelete = this.bookmarkDelete.bind(this);
        this.postLikeStore = this.postLikeStore.bind(this);
        this.postLikeDelete = this.postLikeDelete.bind(this);
        this.postDislikeStore = this.postDislikeStore.bind(this);
        this.postUnDislikeDelete = this.postUnDislikeDelete.bind(this);
    }

    bookmarkStore(postId) {
        this.props.storeBookmark(postId);
    }

    bookmarkDelete(postId) {
        this.props.deleteBookmark(postId);
    }

    postLikeStore(postId) {
        this.props.storePostLike(postId);
    }

    postLikeDelete(postId) {
        this.props.deletePostLike(postId);
    }

    postDislikeStore(postId) {
        this.props.storePostDislike(postId);
    }

    postUnDislikeDelete(postId) {
        this.props.deletePostDislike(postId);
    }

    render() {
        return (
            <div>
                { this.props.posts && this.props.posts.map((post) => {
                        return (
                            <PostListElement key={post.id}
                                             post={post}
                                             bookmarkedPosts={this.props.bookmarkedPosts}
                                             likedPosts={this.props.likedPosts}
                                             dislikedPosts={this.props.dislikedPosts}
                                             handleBookmarkStore={this.bookmarkStore}
                                             handleBookmarkDelete={this.bookmarkDelete}
                                             handlePostLikeStore={this.postLikeStore}
                                             handlePostLikeDelete={this.postLikeDelete}
                                             handlePostDislikeStore={this.postDislikeStore}
                                             handlePostDislikeDelete={this.postUnDislikeDelete}
                            />
                        )
                    })
                }
            </div>
        );
    }
}

const StyledPostListElement = styled.div`
    margin-bottom: 25px;
`;

class PostListElement extends React.Component {
    render() {
        let post = this.props.post;

        const handleBookmarkStore = () => this.props.handleBookmarkStore(post.id);
        const handleBookmarkDelete = () => this.props.handleBookmarkDelete(post.id);
        const bookmarkIconNotActive = (<i className="far fa-bookmark"></i>);
        const bookmarkIconActive = (<i className="fas fa-bookmark"></i>);
        const isPostBookmarked = this.props.bookmarkedPosts && this.props.bookmarkedPosts.includes(post.id);

        const handlePostLikeStore = () => this.props.handlePostLikeStore(post.id);
        const handlePostLikeDelete = () => this.props.handlePostLikeDelete(post.id);
        const postLikeIconActive = (<i className="fas fa-thumbs-up"></i>);
        const postLikeIconNotActive = (<i className="far fa-thumbs-up"></i>);
        const isPostLiked = this.props.likedPosts && this.props.likedPosts.includes(post.id);

        const handlePostDislikeStore = () => this.props.handlePostDislikeStore(post.id);
        const handlePostDislikeDelete = () => this.props.handlePostDislikeDelete(post.id);
        const postDislikeIconActive = (<i className="fas fa-thumbs-down"></i>);
        const postDislikeIconNotActive = (<i className="far fa-thumbs-down"></i>);
        const isPostDisliked = this.props.dislikedPosts && this.props.dislikedPosts.includes(post.id);

        const currentBookmarkAction = isPostBookmarked ? handleBookmarkDelete : handleBookmarkStore;
        const currentBookmarkText = isPostBookmarked ? 'Unbookmark' : 'Bookmark';
        const currentBookmarkIcon = isPostBookmarked ? bookmarkIconActive : bookmarkIconNotActive;

        const currentPostLikeAction = isPostLiked ? handlePostLikeDelete : handlePostLikeStore;
        const currentPostLikeText = isPostLiked ? 'Unlike' : 'Like';
        const currentPostLikeIcon = isPostLiked ? postLikeIconActive : postLikeIconNotActive;

        const currentPostDislikeAction = isPostDisliked ? handlePostDislikeDelete : handlePostDislikeStore;
        const currentPostDislikeText = isPostDisliked ? 'Undislike' : 'Dislike';
        const currentPostDislikeIcon = isPostDisliked ? postDislikeIconActive : postDislikeIconNotActive;

        return (
            <StyledPostListElement className="card">
                <div className="category card-header">
                    Category:&nbsp;
                    <Link to={webRouter.route('category', [post.category.slug])}>
                        {post.category.title}
                    </Link>
                    &nbsp; | &nbsp;
                    {/*<img src={post.author.image}*/}
                    {/*alt={post.author.name}*/}
                    {/*width="50"*/}
                    {/*height="50"*/}
                    {/*/>*/}
                    Author: &nbsp;
                    <Link
                        to={webRouter.route('user', [post.author.id + '-' + post.author.slug])}>{post.author.name}</Link>
                    &nbsp; | &nbsp; Created at: {post.created_at}
                </div>
                <div href={post.link} className="card-body">
                    <h2>Title: {post.title}</h2>
                    <p>Excerpt: {post.excerpt}</p>
                    <button onClick={currentPostLikeAction}>{currentPostLikeText}
                        {currentPostLikeIcon}
                    </button>

                    <p>Rating: {post.rating || '-'}</p>

                     <button onClick={currentPostDislikeAction}>{currentPostDislikeText}
                        {currentPostDislikeIcon}
                    </button>

                    <button onClick={currentBookmarkAction}>{currentBookmarkText}
                        {currentBookmarkIcon}
                    </button>
                   <p>Bookmarks count: {post.bookmarks_count}</p>
                    <p>Comments count: {post.comments_count}</p>
                    <p>TODO Options: hide | report | ignore author | ignore category</p>
                    <Link to={webRouter.route('post', [post.id + '-' + post.slug])}>Go</Link>
                </div>
            </StyledPostListElement>
        )
    }
}

const mapStateToProps = (state, props) => {
    if (!props.posts) {
        return {
            bookmarkedPosts: state.metadata.data.bookmarked_posts,
            posts: state.posts,
        }
    } else {
        return {
            bookmarkedPosts: state.metadata.data.bookmarked_posts,
            likedPosts: state.metadata.data.liked_posts,
            dislikedPosts: state.metadata.data.disliked_posts,
        };
    }
};

const mapDispatchToProps = (dispatch) => ({
    storeBookmark: (postId) => dispatch(storeBookmark(postId)),
    deleteBookmark: (postId) => dispatch(deleteBookmark(postId)),
    storePostLike: (postId) => dispatch(storePostLike(postId)),
    deletePostLike: (postId) => dispatch(deletePostLike(postId)),
    storePostDislike: (postId) => dispatch(storePostDislike(postId)),
    deletePostDislike: (postId) => dispatch(deletePostDislike(postId)),

});

export default connect(mapStateToProps, mapDispatchToProps)(PostList);
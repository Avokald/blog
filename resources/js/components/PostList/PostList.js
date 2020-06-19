import React, {Component} from 'react';
import {connect} from 'react-redux';
import styled from 'styled-components';
import {Link} from "react-router-dom";
import webRouter from "../../routes/WebRouter";
import {deleteBookmark, storeBookmark} from "../../actions";

class PostList extends Component {

    constructor(props) {
        super(props);

        this.bookmarkStore = this.bookmarkStore.bind(this);
        this.bookmarkDelete = this.bookmarkDelete.bind(this);
    }

    bookmarkStore(postId) {
        this.props.storeBookmark(postId);
    }

    bookmarkDelete(postId) {
        this.props.deleteBookmark(postId);
    }

    render() {
        return (
            <div>
                { this.props.posts && this.props.posts.map((post) => {
                        return (
                            <PostListElement key={post.id}
                                             post={post}
                                             bookmarkedPosts={this.props.bookmarkedPosts}
                                             handleBookmarkStore={this.bookmarkStore}
                                             handleBookmarkDelete={this.bookmarkDelete}
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

        const currentBookmarkAction = isPostBookmarked ? handleBookmarkDelete : handleBookmarkStore;
        const currentBookmarkText = isPostBookmarked ? 'Unbookmark' : 'Bookmark';
        const currentBookmarkIcon = isPostBookmarked ? bookmarkIconActive : bookmarkIconNotActive;

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
                    <p>Like &#x1f44d;</p>
                    <p>Rating: {post.rating || '-'}</p>
                    <p>Dislike &#128078;</p>
                    <button onClick={currentBookmarkAction}>{currentBookmarkText} &#128278;
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
        };
    }
};

const mapDispatchToProps = (dispatch) => ({
    storeBookmark: (postId) => dispatch(storeBookmark(postId)),
    deleteBookmark: (postId) => dispatch(deleteBookmark(postId)),

});

export default connect(mapStateToProps, mapDispatchToProps)(PostList);
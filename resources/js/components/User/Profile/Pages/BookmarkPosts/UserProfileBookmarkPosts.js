import React from 'react';
import {connect} from 'react-redux';
import {getUserBookmarkPosts} from "../../../../../actions";
import PostList from "../../../../PostList/PostList";

class RequestLayer extends React.Component {
    componentDidMount() {
        this.props.getUserBookmarkPosts(this.props.userId);
    }

    render() {
        let posts = [];
        for (let bookmark of this.props.bookmarkPosts) {
            posts.push(bookmark.post);
        }

        return (
            <PostList posts={posts} />
        );
    }
}

const mapStateToProps = (state) => ({
    bookmarkPosts: state.userBookmarkPosts.data,
});

const mapDispatchToProps = (dispatch) => ({
    getUserBookmarkPosts: (userId) => dispatch(getUserBookmarkPosts(userId)),
});

export default connect(mapStateToProps, mapDispatchToProps)(RequestLayer);

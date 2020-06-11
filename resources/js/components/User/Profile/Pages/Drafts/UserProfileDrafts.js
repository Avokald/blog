import React from 'react';
import {connect} from 'react-redux';
import {getUserDrafts} from "../../../../../actions";
import PostList from "../../../../PostList/PostList";

class Drafts extends React.Component {
    componentDidMount() {
        this.props.getUserDrafts(this.props.userId);
    }

    render() {
        return (
            <PostList posts={this.props.drafts} />
        );
    }
}

const mapStateToProps = (state) => ({
    drafts: state.userDrafts.data,
});

const mapDispatchToProps = (dispatch) => ({
    getUserDrafts: (userId) => dispatch(getUserDrafts(userId)),
});

export default connect(mapStateToProps, mapDispatchToProps)(Drafts);

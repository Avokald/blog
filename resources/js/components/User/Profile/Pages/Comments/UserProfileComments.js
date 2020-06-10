import React from 'react';
import {connect} from 'react-redux';
import {getUserComments} from "../../../../../actions";
import CommentWithPost from "../../../../Comment/CommentWithPost";

class UserProfileComments extends React.Component {

    componentDidMount() {
        this.props.getUserComments(this.props.userId);
    }

    render() {
        return (
            <React.Fragment>
                { this.props.comments && this.props.comments.map((comment) => {
                    return (<CommentWithPost key={comment.id} comment={comment} />);
                })
                }
            </React.Fragment>
        );
    }
}

const mapStateToProps = (state) => ({
    comments: state.userComments.data,
});

const mapDispatchToProps = (dispatch) => ({
    getUserComments: (userId) => dispatch(getUserComments(userId)),
});

export default connect(mapStateToProps, mapDispatchToProps)(UserProfileComments);
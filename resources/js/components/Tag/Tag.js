import React from 'react';
import {connect} from 'react-redux';

class Tag extends React.Component {

    render() {
        let tag = this.props.tag;
        return (
            <div>
                <p>{tag.title}</p>
            </div>
        );
    }
}

const mapStateToProps = (state, props) => {
    let currentTag = null;

    let slug = props.match.params.tag;

    for (let tag of state.tags) {
        if (tag.title === slug) {
            currentTag = tag;
        }
    }

    return {
        tag: currentTag,
    }
};

export default connect(mapStateToProps, null)(Tag);

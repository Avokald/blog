import React from 'react';
import {Link} from "react-router-dom";
import {connect} from 'react-redux';

const tags = (props) => {
    return (
        <div>
            { props.tags.map((tag) => {
                return (
                    <React.Fragment key={tag.id}>
                        <div>{tag.title}</div>
                        <Link to={'/tag/' + tag.title }>
                            Go
                        </Link>
                    </React.Fragment>
                );
            }) }
        </div>
    );
};

const mapStateToProps = (state) => {
    return {
        tags: state.tags,
    };
};

export default connect(mapStateToProps, null)(tags);
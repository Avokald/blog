import React, {Component} from 'react';
import {connect} from 'react-redux';


class Category extends Component {

    render() {
        let category = this.props.category;
        return (
            <div>
                <img src={category.banner} />
                <br />
                <img src={category.image} />
                <p>{category.title}</p>
                <p>{category.description}</p>
            </div>
        );
    }
}

const mapStateToProps = (state, props) => {
    let currentCategory = null;

    let slug = props.match.params.category;

    for (let category of state.categories) {
        if (category.slug === slug) {
            currentCategory = category;
        }
    }

    return {
        category: currentCategory,
    }
};

export default connect(mapStateToProps, null)(Category);
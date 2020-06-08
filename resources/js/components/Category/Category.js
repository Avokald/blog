import React, {Component} from 'react';
import {connect} from 'react-redux';
import {getCategory} from "../../actions";
import PostList from "../PostList/PostList";


class Category extends Component {
    componentDidMount() {
        this.props.getCategory(this.props.match.params.category);
    }

    render() {
        let category = this.props.categoriesData;
        return (
            <div>
                <img src={category.banner} />
                <br />
                <img src={category.image} />
                <p>{category.title}</p>
                <p>{category.description}</p>

                <PostList posts={this.props.category.posts} />
            </div>
        );
    }
}

const mapStateToProps = (state, props) => {
    let currentCategory = null;

    let slug = props.match.params.category;

    for (let category of state.categories.data) {
        if (category.slug === slug) {
            currentCategory = category;
        }
    }

    return {
        categoriesData: currentCategory,
        category: state.category.data,
    }
};

const mapDispatchToProps = (dispatch) => ({
    getCategory: (slug) => dispatch(getCategory(slug))
});

export default connect(mapStateToProps, mapDispatchToProps)(Category);
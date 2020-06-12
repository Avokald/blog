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
                {category.banner && (
                    <div style={
                        {
                            width: '640px',
                            height: '160px',
                            overflow: 'hidden',
                    }}>
                        <img src={category.banner}
                             width="640"
                             height="auto"
                        />
                    </div>
                )}
                <br />
                <img src={category.image}
                     width="40"
                     height="40"
                />
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
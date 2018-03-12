import React from "react";
import {Component} from "react/lib/ReactIsomorphic";

class SearchBar extends Component {
    constructor(props) {
        super(props);

        this.state = { term: '' }
    }

    render() {
        return (
            <div className="col-md-12 search-bar">
                Search video:&nbsp;
                <input
                    value={this.state.term}
                    onChange={event => this.onInputChange(event.target.value)}
                />
            </div>
        );
    }

    onInputChange(term) {
        this.setState({term});
        this.props.onSearchTermChange(term);
    }
}

export default SearchBar;

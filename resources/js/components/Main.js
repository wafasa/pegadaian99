import React, { Component } from 'react';

export default class Main extends Component {
    constructor() {
        super()
        this.state = {
            name: 'mantab'
        }
    }

    render() {
        return (
            <div>
                <h1>
                    Utama
                </h1>
            </div>
        );
    }
}

ReactDOM.render(<Main />, document.getElementById('app'));

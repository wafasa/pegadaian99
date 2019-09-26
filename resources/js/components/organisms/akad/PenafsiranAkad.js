import React, {Component, Fragment} from 'react';
import TimeAkad from '../../molecules/TimeAkad';
import InsuranceItem from '../../molecules/InsuranceItem';

class BasePenafsiranAkad extends Component{
    render(){
        return(
            <Fragment>
                <TimeAkad/>
                <br/>
                <InsuranceItem/>
            </Fragment>

        )
    }
}

export default BasePenafsiranAkad;

/* tslint:disable:ordered-imports */
import * as React from 'react';

class JqxRating extends React.PureComponent<IRatingProps, IState> {
    protected static getDerivedStateFromProps(props: IRatingProps, state: IState): null | IState {
        if (!Object.is) {
            Object.is = function (x, y) {
                if (x === y) {
                    return x !== 0 || 1 / x === 1 / y;
                } else {
                    return x !== x && y !== y;
                }
            };
        }

        const areEqual = Object.is(props, state.lastProps) as boolean;

        if (!areEqual) {
            const newState = { lastProps: props } as IState;
            return newState;
        }

        return null;
    }

    /* tslint:disable:variable-name */
    private _jqx = JQXLite as any;
    /* tslint:disable:variable-name */
    private _id: string;
    /* tslint:disable:variable-name */
    private _componentSelector: string;

    constructor(props: IRatingProps) {
        super(props);

        this._id = 'JqxRating' + this._jqx.generateID();
        this._componentSelector = '#' + this._id;

        this.state = { lastProps: props };
    }

    public componentDidMount(): void {
        const widgetOptions = this._manageProps() as IRatingProps;
        this._jqx(this._componentSelector).jqxRating(widgetOptions);
        this._wireEvents();
    }

    public componentDidUpdate(): void {
        const widgetOptions = this._manageProps() as IRatingProps;
        this.setOptions(widgetOptions);
    }

    public render(): React.ReactNode {
        return (
            <div id={this._id} className={this.props.className} style={this.props.style}>
                {this.props.children}
            </div>
        );
    }

    public setOptions(options: IRatingProps): void {
        this._jqx(this._componentSelector).jqxRating(options);
    }

    public getOptions(option: string): any {
        return this._jqx(this._componentSelector).jqxRating(option);
    }

    public disable(): void {
        this._jqx(this._componentSelector).jqxRating('disable' );
    };

    public enable(): void {
        this._jqx(this._componentSelector).jqxRating('enable' );
    };

    public getValue(): number {
        return this._jqx(this._componentSelector).jqxRating('getValue' );
    };

    public setValue(value: number): void {
        this._jqx(this._componentSelector).jqxRating('setValue' , value);
    };

    public val(value?: number): number {
        return this._jqx(this._componentSelector).jqxRating('val' , value);
    };

    private _manageProps(): IRatingProps {
        const widgetProps: string[] = ['count','disabled','height','itemHeight','itemWidth','precision','singleVote','value','width'];

        const options = {} as IRatingProps;

        for (const prop in this.props) {
            if (widgetProps.indexOf(prop) !== -1) {
                 options[prop] = this.props[prop];
            }
        }

        return options;
    }

    private _wireEvents(): void {
        for (const prop in this.props) {
            if (prop.indexOf('on') === 0) {
                let originalEventName = prop.slice(2) as string;
                originalEventName = originalEventName.charAt(0).toLowerCase() + originalEventName.slice(1);
                this._jqx(this._componentSelector).on(originalEventName, this.props[prop]);
            }
        }
    }
}

export default JqxRating;

interface IWindow { jqx: any;  JQXLite: any; }
declare const window: IWindow;
export const jqx = window.jqx;
export const JQXLite = window.JQXLite;

interface IState {
    lastProps: object;
}

interface IRatingOptions {
    count?: number;
    disabled?: boolean;
    height?: string | number;
    itemHeight?: number;
    itemWidth?: number;
    precision?: number;
    singleVote?: boolean;
    value?: number;
    width?: string | number;
}

export interface IRatingProps extends IRatingOptions {
    className?: string; 
    style?: React.CSSProperties; 
    onChange?: (e?: Event) => void;
}

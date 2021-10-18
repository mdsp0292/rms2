import React from 'react';
import ReactSelect from 'react-select';
import makeAnimated from 'react-select/animated';

const animatedComponents = makeAnimated();

export default ({
                    label,
                    name,
                    className,
                    options,
                    errors = [],
                    ...props
                }) => {
    return (
        <div className={className}>
            {label && (
                <label className="form-label" htmlFor={name}>
                    {label}:
                </label>
            )}
            <ReactSelect
                id={name}
                name={name}
                {...props}
                className={`${errors.length ? 'error' : ''}`}
                //closeMenuOnSelect={false}
                components={animatedComponents}
                options={options}
            />

            {errors && <div className="form-error">{errors[0]}</div>}
        </div>
    );
};


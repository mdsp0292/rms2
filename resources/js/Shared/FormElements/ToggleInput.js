import React from 'react';

export default ToggleInput;

function ToggleInput({ label, name, className, errors = false, ...props}) {
    return (
        <div className={className}>
            <label className="form-label" htmlFor={name}> {label} </label>
            <div className="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                <input
                    type="checkbox"
                    id={name}
                    name={name}
                    {...props}
                    className={`form-toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer ${errors.length ? 'error' : ''}  ${props.disabled ? ' bg-gray-100' : ''}`}
                />

                <label
                    className="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"
                    htmlFor={name}
                />

            </div>
            {errors && <div className="form-error">{errors}</div>}
        </div>
    );
}

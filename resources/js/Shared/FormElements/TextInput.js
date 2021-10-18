import React from 'react';

export default ({ label, name, className, errors = [], ...props }) => {
  return (
    <div className={className}>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}
      <input
        id={name}
        name={name}
        {...props}
        className={`placeholder-gray-500 form-input ${errors.length ? 'error' : ''}  ${props.disabled ? ' bg-gray-100' : ''}`}
      />
      {errors && <div className="form-error">{errors}</div>}
    </div>
  );
};

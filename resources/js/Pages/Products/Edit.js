import React, { useState } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import DeleteButton from '@/Shared/DeleteButton';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import TrashedMessage from '@/Shared/TrashedMessage';

const Edit = () => {
  const { product, errors } = usePage().props;
  const [sending, setSending] = useState(false);

  const [values, setValues] = useState({
    name: product.name || '',
    amount: product.amount || '',
  });

  function handleChange(e) {
    const key = e.target.name;
    const value = e.target.value;
    setValues(values => ({
      ...values,
      [key]: value
    }));
  }

  function handleSubmit(e) {
    e.preventDefault();
    setSending(true);
    Inertia.put(route('products.update', product.id), values, {
      onFinish: () => setSending(false)
    });
  }

  function destroy() {
    if (confirm('Are you sure you want to delete this product?')) {
      Inertia.delete(route('products.destroy', product.id));
    }
  }

  function restore() {
    if (confirm('Are you sure you want to restore this product?')) {
      Inertia.put(route('products.restore', product.id));
    }
  }

  return (
    <div>
      <Helmet title={`${values.name}`} />
      <h1 className="mb-8 text-3xl font-bold">
        <InertiaLink
          href={route('products')}
          className="text-indigo-600 hover:text-indigo-700"
        >
            Products
        </InertiaLink>
        <span className="mx-2 font-medium text-indigo-600">/</span>
        {values.name}
      </h1>
      {product.deleted_at && (
        <TrashedMessage onRestore={restore}>
          This product has been deleted.
        </TrashedMessage>
      )}
      <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
        <form onSubmit={handleSubmit}>
          <div className="flex flex-wrap p-8 -mb-8 -mr-6">
              <TextInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="Product Name"
                  name="name"
                  errors={errors.name}
                  value={values.name}
                  onChange={handleChange}
              />


              <TextInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="Amount"
                  name="amount"
                  type="number"
                  errors={errors.amount}
                  value={values.amount}
                  onChange={handleChange}
              />

          </div>
          <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
            {!product.deleted_at && (
              <DeleteButton onDelete={destroy}>Delete product</DeleteButton>
            )}
            <LoadingButton
              loading={sending}
              type="submit"
              className="ml-auto btn-indigo"
            >
              Update product
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

Edit.layout = page => <Layout children={page} />;

export default Edit;

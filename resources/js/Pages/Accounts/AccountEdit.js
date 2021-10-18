import React, { useState } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import DeleteButton from '@/Shared/DeleteButton';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/FormElements/TextInput';
import SelectInput from '@/Shared/FormElements/SelectInput';
import TrashedMessage from '@/Shared/TrashedMessage';

const AccountEdit = () => {
  const { account, errors } = usePage().props;
  const [sending, setSending] = useState(false);

  const [values, setValues] = useState({
    name: account.name || '',
    email: account.email || '',
    phone: account.phone || '',
    street: account.street || '',
    city: account.city || '',
    state: account.state || '',
    country: account.country || '',
    post_code: account.post_code || ''
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
    Inertia.put(route('accounts.update', account.id), values, {
      onFinish: () => setSending(false)
    });
  }

  function destroy() {
    if (confirm('Are you sure you want to delete this account?')) {
      Inertia.delete(route('accounts.destroy', account.id));
    }
  }

  function restore() {
    if (confirm('Are you sure you want to restore this contact?')) {
      Inertia.put(route('contacts.restore', contact.id));
    }
  }

  return (
    <div>
      <Helmet title={`${values.name}`} />
      <h1 className="mb-8 text-3xl font-bold">
        <InertiaLink
          href={route('accounts')}
          className="text-indigo-600 hover:text-indigo-700"
        >
          Accounts
        </InertiaLink>
        <span className="mx-2 font-medium text-indigo-600">/</span>
        {values.name}
      </h1>
      {account.deleted_at && (
        <TrashedMessage onRestore={restore}>
          This account has been deleted.
        </TrashedMessage>
      )}
      <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
        <form onSubmit={handleSubmit}>
          <div className="flex flex-wrap p-8 -mb-8 -mr-6">
              <TextInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="Account Name"
                  name="name"
                  errors={errors.name}
                  value={values.name}
                  onChange={handleChange}
              />

              <TextInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="Email"
                  name="email"
                  type="email"
                  errors={errors.email}
                  value={values.email}
                  onChange={handleChange}
              />
              <TextInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="Phone"
                  name="phone"
                  type="text"
                  errors={errors.phone}
                  value={values.phone}
                  onChange={handleChange}
              />
              <TextInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="Street"
                  name="street"
                  type="text"
                  errors={errors.street}
                  value={values.street}
                  onChange={handleChange}
              />
              <TextInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="City"
                  name="city"
                  type="text"
                  errors={errors.city}
                  value={values.city}
                  onChange={handleChange}
              />
              <TextInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="State"
                  name="state"
                  type="text"
                  errors={errors.state}
                  value={values.state}
                  onChange={handleChange}
              />
              <SelectInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="Country"
                  name="country"
                  errors={errors.country}
                  value={values.country}
                  onChange={handleChange}
              >
                  <option value="AU">AU</option>
              </SelectInput>
              <TextInput
                  className="w-full pb-8 pr-6 lg:w-1/2"
                  label="Post Code"
                  name="post_code"
                  type="text"
                  errors={errors.post_code}
                  value={values.post_code}
                  onChange={handleChange}
              />
          </div>
          <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
            {!account.deleted_at && (
              <DeleteButton onDelete={destroy}>Delete Account</DeleteButton>
            )}
            <LoadingButton
              loading={sending}
              type="submit"
              className="ml-auto btn-indigo"
            >
              Update Account
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

AccountEdit.layout = page => <Layout children={page} />;

export default AccountEdit;

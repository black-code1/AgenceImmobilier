<x-mail::message>
# Nouvelle demade de contact

Une nouvelle demande de contact a ete fait pour le bien <a href="{{ route('property.show', ['slug' => $property->getSlug(), 'property' => $property]) }}">{{ $property->title }}</a>.

- Prenom : {{ $data['firstname'] }}
- Nom : {{ $data['lastname'] }}
- Telephone : {{ $data['phone'] }}
- Email : {{ $data['email'] }}

**Message :**<br/>
{{ $data['message'] }}
</x-mail::message>
